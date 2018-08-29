<?php
/**
 * User: Major
 * Date: 2018/4/14
 * Time: 14:06
 */

namespace Totoro\Mvc;

use Totoro\Mvc\Routing\RouteResult;

abstract class Controller
{
    public static $GET;
    public static $POST;
    public static $REQUEST;
    public static $COOKIE;

    protected $pageVariable = array();
    protected $route_result;

    public final function __construct()
    {
        $this->init();
    }

    /*
     * assign
     * 向HtmlView输出数据
     */
    protected function assign($key, $value)
    {
        $this->pageVariable[$key] = $value;
        return true;
    }

    protected function setPageVariable(array $data)
    {
        $this->pageVariable = $data;
        return true;
    }

    /**
     * htmlView
     * 通过HtmlView用来输出一个Html页面
     * controller执行的最后一步
     */
    protected function htmlView($tmpl)
    {
        $view = new View\HtmlView($tmpl);
        $view->setData($this->pageVariable);
        return $view;
    }

    /**
     * jsonView
     * 返回一个JsonView对象，自定义数据与返回状态
     * controller执行的最后一步
     */
    protected function jsonView($json_data)
    {
        $view = new View\JsonView();
        $view->setData($json_data);
        return $view;
    }

    protected function jsonpView($jsoncallback, $json_data)
    {
        $view = new View\JsonView();
        $view->setData($json_data);
        $view->setJavaScriptCallback($jsoncallback);
        return $view;
    }

    /*
     * redirect
     * 跳转到指定的url
     */
    protected function redirect($url, $permanently = false)
    {
        $view = new View\RedirectionView();
        $view->setUrl($url);
        $view->setPermanently($permanently);
        return $view;
    }

    protected function redirectPermanently($url)
    {
        return $this->redirect($url, true);
    }

    //events
    protected function init()
    {
        return;
    }

    /**
     * onActionExecuting
     * action 执行前事件方法，子类覆盖完成自定义逻辑
     */
    public function onActionExecuting()
    {
        return;
    }

    /**
     * onActionExecuted
     * action 执行事件后事件方法，子类覆盖完成自定义逻辑
     */
    public function onActionExecuted()
    {
        return;
    }

    /**
     * setRouteResult
     */
    public function setRouteResult(RouteResult $route_result)
    {
        $this->route_result = $route_result;
    }

    public function getRouteResult()
    {
        return $this->route_result;
    }
}