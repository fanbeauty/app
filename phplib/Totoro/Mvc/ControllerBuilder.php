<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:07
 */

namespace Totoro\Mvc;


use Totoro\Mvc\Routing\RouteResult;

class ControllerBuilder implements IControllerBuilder
{
    public function build(RouteResult $route_result)
    {
        //路由匹配到的内容
        $sub_namespace = str_replace('/', '\\', $route_result->getParams('sub-namespace'));
        $rr_controller = $route_result->getParams('controller');
        $rr_action = $route_result->getParams('action');

        //规则中默认的参数
        $namespace = $route_result->getNamespace();
        $df_controller = $route_result->getRoute()->getDefault('controller');
        $df_action = $route_result->getRoute()->getDefault('action');

        /*
            情况一
            访问路径: /
            sub_namespace: null
            rr_controller: default
            rr_action: index
            目标匹配可能:
                namespace\defaultController->indexAction

            情况二
            访问路径: /c
            sub_namespace: c
            rr_controller: default
            rr_action: index
            目标匹配可能:
                namespace\defaultController->cAction
                namespace\cController->indexAction
                namespace\c\defaultController->indexAction

            情况三
            访问路径: /c/b
            sub_namespace: c
            rr_controller: b
            rr_action: index
            目标匹配可能:
                namespace\cController->bAction
                namespace\c\bController->indexAction
                namespace\c\b\defaultController->indexAction

            情况四
            访问路径: /.../b/a
            sub_namespace: c
            rr_controller: b
            rr_action: a
            目标匹配可能:
                namespace\...\bController->aAction
                namespace\...\b\aController->indexAction
                namespace\...\b\a\defaultController->indexAction
         */

        $queue = array();
        if (!$sub_namespace) {
            //情况一
            $queue[] = array(
                'controller' => "{$namespace}\\{$rr_controller}Controller",
                'action' => $rr_action
            );
        } else {
            if ($rr_action == $df_action) {
                if ($rr_controller == $df_controller) {
                    //情况二
                    $queue[] = array(
                        'controller' => "{$namespace}\\{$sub_namespace}\\{$df_controller}Controller",
                        'action' => $df_action
                    );
                    $queue[] = array(
                        'controller' => "{$namespace}\\{$sub_namespace}Controller",
                        'action' => $df_action
                    );
                    $queue[] = array(
                        'controller' => "{$namespace}\\{$df_controller}Controller",
                        'action' => $df_action
                    );
                } else {
                    //情况三
                    $queue[] = array(
                        'controller' => "{$namespace}\\{$sub_namespace}\\{$rr_controller}\\{$df_controller}Controller",
                        'action' => $df_action
                    );
                    $queue[] = array(
                        'controller' => "{$namespace}\\{$sub_namespace}\\{$rr_controller}Controller",
                        'action' => $df_action
                    );
                    $queue[] = array(
                        'controller' => "{$namespace}\\{$sub_namespace}Controller",
                        'action' => $rr_action
                    );
                }
            } else {
                //第四种情况
                $queue[] = array(
                    'controller' => "{$namespace}\\{$sub_namespace}\\{$rr_controller}\\{$rr_action}\\{$df_controller}Controller",
                    'action' => $df_action
                );
                $queue[] = array(
                    'controller' => "{$namespace}\\{$sub_namespace}\\{$rr_controller}\\{$rr_action}Controller",
                    'action' => $df_action
                );
                $queue[] = array(
                    'controller' => "{$namespace}\\{$sub_namespace}\\{$rr_controller}Controller",
                    'action' => $rr_action
                );
            }
        }

        foreach ($queue as $q) {
            if (is_subclass_of($q['controller'], '\Totoro\Mvc\Controller')) {
                if (method_exists($q['controller'], $q['action'] . 'Action')) {

                    $class = $q['controller'];
                    $route_result->setParams('action', $q['action']);
                    break;
                }
            }
        }

        if ($class) {
            $class_reflection = new \ReflectionClass($class);
            if ($class_reflection->isInstantiable()) {
                return new $class();
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
