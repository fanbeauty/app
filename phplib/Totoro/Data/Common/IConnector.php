<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 23:06
 */

namespace Totoro\Data\Common;

interface IConnector
{
    public function getMasterConnection();

    public function getSlaveConnection();

    public function getBackupConnection();

    public function getTransactionConnection($tag);
}