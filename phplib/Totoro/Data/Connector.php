<?php
/**
 * User: Major
 * Date: 2018/4/21
 * Time: 14:37
 */

namespace Totoro\Data;


use Totoro\Data\Common\IConnector;
use Totoro\Data\MySQL\CommandND;
use Totoro\Data\MySQL\ConnectionND;

abstract class Connector implements IConnector
{

    private static $master = null;
    private static $slave = null;
    private static $backup = null;
    private static $transactionList = array();

    abstract public function getMasterConf();

    abstract public function getSlaveConf();

    abstract public function getBackupConf();

    abstract public function getTransactionConf();

    public final function __construct()
    {
    }

    public function getMasterConnection()
    {
        if (self::$master === null) {
            self::$master = new ConnectionND($this->getMasterConf());
        }
        return self::$master;
    }

    public function getSlaveConnection()
    {
        if (self::$slave === null) {
            self::$slave = new ConnectionND($this->getSlaveConf());
        }
        return self::$slave;
    }

    public function getBackupConnection()
    {
        if (self::$backup === null) {
            self::$backup = new ConnectionND($this->getBackupConf());
        }
        return self::$backup;
    }

    public function getTransactionConnection($tag)
    {
        if (!isset(self::$transactionList[$tag])) {
            self::$transactionList[$tag] = new ConnectionND($this->getTransactionConf());
        }
        return self::$transactionList[$tag];
    }
}