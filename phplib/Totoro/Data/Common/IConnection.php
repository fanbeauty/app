<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 13:53
 */

namespace Totoro\Data\Common;

interface IConnection
{
    public function __construct(ConnectionConfig $config);

    /**
     * 返回一个操作数据库的ICommand
     * @return ICommand
     */
    public function getCommand();

    /**
     * 重新连接数据库
     * @return bool 是否成功
     */
    public function reConnect();

    public function getRealConnection();
}