<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 20:44
 */

namespace App\Mvc;

use App\Constants\ApiStatus;
use Totoro\Mvc\Controller;

/**
 * Class BaseController
 * controller类的基础
 * @package App\Mvc
 */
abstract class BaseController extends Controller
{
    protected function htmlView($tmpl)
    {
        return parent::htmlView($tmpl);
    }

    protected function jsonData($data, $message = '')
    {
        return $this->jsonView(
            array(
                'errno' => ApiStatus::SUCCESS,
                'error' => $message,
                'data' => $data,
            )
        );
    }

    protected function jsonpData($data, $message = '', $jsoncallback = 'jsoncallback')
    {
        return $this->jsonpView(
            $jsoncallback,
            array(
                'errno' => ApiStatus::SUCCESS,
                'error' => $message,
                'data' => $data,
            )
        );
    }

    /**
     * jsonStatus
     * 返回一个JsonView对象，用于处理请求失败情况下的返回状态
     */
    protected function jsonStatus($errno, $message = '')
    {
        return $this->jsonView(
            array(
                'errno' => $errno,
                'error' => $message,
                'data' => new \stdClass(),
            )
        );
    }

    /*
     * jsonpStatus
     */
    protected function jsonpStatus($errno, $message = null, $jsoncallback = 'jsonpcallback')
    {
        return $this->jsonpView(
            $jsoncallback,
            array(
                'errno' => intval($errno),
                'error' => $message,
                'data' => null,
            )
        );
    }

    protected function jsonSuccess($message = '')
    {
        return $this->jsonStatus(ApiStatus::SUCCESS, $message);
    }


    protected function jsonpSuccess($message = null, $jsoncallback = 'jsonpcallback')
    {
        return $this->jsonpStatus(ApiStatus::SUCCESS, $message, $jsoncallback);
    }
}
