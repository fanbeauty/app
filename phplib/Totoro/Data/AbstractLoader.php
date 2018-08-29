<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 23:23
 */

namespace Totoro\Data;

abstract class AbstractLoader
{
    final public function getDetail($prikey)
    {
        $info_list = $this->getDetailList($prikey);
        return isset($info_list[0]) ? $info_list[0] : [];
    }

    abstract public function getDetailList(array $prikey_list);
}