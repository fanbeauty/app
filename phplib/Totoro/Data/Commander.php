<?php
/**
 * User: Major
 * Date: 2018/4/21
 * Time: 13:24
 */

namespace Totoro\Data;

use Totoro\Data\Common\IConnector;
use Totoro\Data\Common\ITransactable;
use Totoro\Data\Common\ServerType;
use Totoro\Data\Exception\DatabaseException;

class Commander implements ITransactable
{
    private $transStatus = array();
    private $connector;
    private $transactionTag = null;

    public function getCommand($server_type = ServerType::MASTER)
    {
        if ($this->transactionTag) {
            $conn = $this->connector->getTransactionConnection($this->transactionTag);
        } else {
            if ($server_type == ServerType::MASTER) {
                $conn = $this->connector->getMasterConnection();
            } else if ($server_type == ServerType::SLAVE) {
                $conn = $this->connector->getSlaveConnection();
            } else if ($server_type == ServerType::BACKUP) {
                $conn = $this->connector->getBackupConnection();
            } else {
                throw new DatabaseException(
                    DatabaseException::CONNECT_ERR, 'server type error', 0
                );
            }
        }
        return $conn->getCommand();
    }


    public function __construct(IConnector $connector)
    {
        $this->connector = $connector;
        $this->connector_string = get_class($connector);
    }

    public function escapeString($str, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand($server_type);
        return $comm->escapeString($str);
    }

    public function getRowBySql($sql, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand($server_type);
        $data_set = $comm->execDataSetBySql($sql);
        return count($data_set) ? $data_set[0] : array();
    }

    public function getAllBySql($sql, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand($server_type);
        $result = $comm->execDataSetBySql($sql);
        return $result;
    }

    public function getDataReaderBySql($sql, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand($server_type);
        $result = $comm->execDataReaderBySql($sql);
        return $result;
    }

    public function executeBySql($sql)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $result = $comm->executeNonQueryBySql($sql);
        return $result;
    }

    public function executeBySqlWithLastInsertId($sql, &$lastInsertId = null)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $result = $comm->executeNonQueryBySql($sql);
        if ($result) {
            $lastInsertId = $comm->lastInsertId();
            if ($lastInsertId) {
                $lastInsertId = intval($lastInsertId);
            } else {
                $lastInsertId = false;
            }
        }
        return $result;
    }

    /*
     * 通过statement来查询数据
     */
    public function getRow($sql, array $type_array, array $value_array, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $data_set = $comm->executeDataSet($sql, $type_array, $value_array);
        return count($data_set) ? $data_set[0] : array();
    }

    public function getAll($sql, array $type_array, array $value_array, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $result = $comm->executeDataSet($sql, $type_array, $value_array);
        return $result;
    }

    public function getDataReader($sql, array $type_array, array $value_array, $server_type = ServerType::SLAVE)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $result = $comm->executeDataReader($sql, $type_array, $value_array);
        return $result;
    }

    public function execute($sql, array $type_array, array $value_array)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $result = $comm->executeNonQuery($sql, $type_array, $value_array);
        return $result;
    }

    public function executeWithLastInsertId($sql, array $type_array, array $value_array, &$lastInsertId)
    {
        $comm = $this->getCommand(ServerType::MASTER);
        $result = $comm->executeNonQuery($sql, $type_array, $value_array);
        if ($result) {
            $lastInsertId = $comm->lastInsertId();
            if ($lastInsertId) {
                $lastInsertId = intval($lastInsertId);
            } else {
                $lastInsertId = false;
            }
        }
        return $result;
    }

    public function inTransaction()
    {
        if (isset($this->transactionTag)) {
            return $this->transStatus[$this->transactionTag];
        } else {
            return null;
        }
    }

    public function begin()
    {
        $this->transStatus[$this->transactionTag] = true;
        $comm = $this->connector->getTransactionConnection($this->getTransactionTag())->getCommand();
        return $comm->begin();
    }

    public function commit()
    {
        $this->transStatus[$this->transactionTag] = false;
        $comm = $this->connector->getTransactionConnection($this->getTransactionTag())->getCommand();
        return $comm->commit();
    }

    public function rollback()
    {
        $this->transStatus[$this->transactionTag] = false;
        $comm = $this->connector->getTransactionConnection($this->getTransactionTag())->getCommand();
        return $comm->rollback();
    }

    public function usingTransactionWithTag($tag)
    {
        $this->transactionTag = $tag;
    }

    public function getTransactionTag()
    {
        return $this->transactionTag;
    }
}