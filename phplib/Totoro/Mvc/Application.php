<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:06
 */

namespace Totoro\Mvc;

use Totoro\Env;
use Totoro\Mvc\Exception\ActionNotFound;
use Totoro\Mvc\Exception\ApplicationException;
use Totoro\Mvc\Exception\ControllerNotFound;
use Totoro\Mvc\Exception\ControllerTypeException;
use Totoro\Mvc\Exception\RedirectionException;
use Totoro\Mvc\Exception\RouteException;
use Totoro\Mvc\Exception\RoutesNotMatched;
use Totoro\Mvc\Exception\ViewTypeException;
use Totoro\Mvc\Input\Cookie;
use Totoro\Mvc\Input\Get;
use Totoro\Mvc\Input\Post;
use Totoro\Mvc\Input\Request;
use Totoro\Mvc\Routing\Router;
use Totoro\Mvc\Routing\Route;


/**
 * Application
 * mvc application 生命周期控制器，用于控制框架执行流程、异常处理、安全过滤等
 * Class Application
 * @package Totoro\Mvc
 */
class Application implements IExceptionCallback
{
    private static $instance = null;
    private $router;
    private $call_back;
    private $builder = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->router = Router::getInstance();
        $this->call_back = $this;
    }


    public function mapRoute($name, $patten, $defaults = array(), $constraints = array(), $namespace = null)
    {
        $this->router->add($name, $patten, $defaults, $constraints, $namespace);
    }

    public function setExceptionCallback(IExceptionCallback $call_back)
    {
        $this->call_back = $call_back;
    }

    public function setControllerBuilder(IControllerBuilder $builder)
    {
        $this->builder = $builder;
    }

    public static function getViewByExecutingAction(Controller $controller, $action, $params = array())
    {
        $method = "{$action}Action";
        //获取View对象
        if (method_exists($controller, $method)) {
            $method_reflection = new \ReflectionMethod($controller, $method);
            $param_key_list = $method_reflection->getParameters();

            $controller->onActionExecuting();

            if (count($param_key_list) > 0) {
                $param_list = array();
                foreach ($param_key_list as $k) {
                    $param_list[] = $params[$k->name];
                }
                $view = call_user_func_array(array($controller, $method), $param_list);
            } else {
                $view = $controller->$method();
            }
            $controller->onActionExecuted();
            return $view;
        } else {
            throw new ActionNotFound(get_class($controller), $action);
        }
    }


    public function start($request_string)
    {
        try {
            try {
                $route_result = $this->router->route($request_string);
                if ($route_result) {
                    try {
                        //初始化输入参数
                        $env = Env::getInstance();
                        Controller::$COOKIE = Cookie::getInstance();
                        Controller::$GET = Get::getInstance();
                        Controller::$POST = Post::getInstance();
                        Controller::$REQUEST = Request::getInstance();
                        if ($env->isUnsetRequestGlobals()) {
                            unset($_REQUEST, $_COOKIE, $_GET, $_POST);
                        }
                        //初始化controller
                        if ($this->builder == null) {
                            $builder = new ControllerBuilder();
                        } else {
                            $builder = $this->builder;
                        }
                        $controller = $builder->build($route_result);
                        if ($controller) {
                            if (is_subclass_of($controller, 'Totoro\Mvc\Controller')) {
                                $controller->setRouteResult($route_result);
                                //执行action 获得 View对象
                                $action = $route_result->getParams('action');
                                $view = self::getViewByExecutingAction(
                                    $controller, $action, $route_result->getParamArray()
                                );
                                //输出view
                                if (is_subclass_of($view, 'Totoro\Mvc\View\View')) {
                                    //MVC 框架执行最后一步
                                    $view->output();
                                    return;
                                } else {
                                    $type = gettype($view);
                                    throw new ViewTypeException(
                                        $type == 'object' ? get_class($view) : $type
                                    );
                                }
                            } else {
                                $type = gettype($controller);
                                throw new ControllerTypeException(
                                    $type == 'object' ? get_class($controller) : $type
                                );
                            }
                        } else {
                            throw new ControllerNotFound($route_result, $builder);
                        }
                    } catch (RedirectionException $e) {
                        //RedirectionException 框架内仅处理一次，避免循环跳转
                        $view = $e->getView();
                        //MVC框架执行的最后一步
                        $view->output();
                        return;
                    }
                } else {
                    throw new RoutesNotMatched($request_string);
                }
            } catch (\Exception $e) {
                throw $e;
            }
        } catch (ApplicationException $e) {
            $this->call_back->onApplicationException($e);
        } catch (RouteException $e) {
            $this->call_back->onRouteException($e);
        } catch (\Exception $e) {
            $this->call_back->onException($e);
        }
        return;
    }


    public function onRouteException(RouteException $e)
    {
        header('HTTP/1.1 404 Not Found');
        header('status: 404 Not Found');
        $this->renderException($e);

        echo '<br/><br/>';

        switch (get_class($e)) {
            case 'Totoro\Mvc\Exception\ActionNotFound':
                echo $e->getControllerName() . ' ';
                echo $e->getRequestActionName();
                break;
            case 'Totoro\Mvc\Exception\ControllerNotFound':
                $result = $e->getRouteResult();
                $controller = $result->getParams('controller');
                $action = $result->getParams('action');
                echo '<b>Controller Builder Name:</b> ' . $e->getControllerBuilderName() . '<br />';
                echo "<b>Controller Name:</b> {$controller}<br />";
                echo "<b>Action Name:</b> {$action}<br />";
                break;
            case 'Totoro\Mvc\Exception\ControllerTypeException':
                echo '<b>' . $e->getInvalidType() . '</b> returns, Zeus\Mvc\Controller expected.';
                break;
            case 'Totoro\Mvc\Exception\RoutesNotMatched':
                echo $e->getRequestString();
                break;
            case 'Totoro\Mvc\Exception\RuleException':
                echo $e->getName() . ' ';
                // $e->getRoute();
                echo $e->getMessage();
                break;
            case 'Totoro\Mvc\Exception\ViewTypeException':
                echo '<b>' . $e->getInvalidType() . '</b> returns, Zeus\Mvc\View\View expected.';
                break;
        }
    }

    public function onApplicationException(ApplicationException $e)
    {
        $this->renderException($e);
    }

    public function onException(\Exception $e)
    {
        header('HTTP/1.1 500 Internal Server Error');
        $this->renderException($e);
    }

    private function renderException(\Exception $e)
    {
        echo 'throw<b>' . get_class($e) . '</b></br>';
        echo '@' . $e->getFile() . ' ' . $e->getLine() . '<br/>';
        echo $e->getMessage() . '<br/>';
        echo nl2br($e->getTraceAsString());
    }

}