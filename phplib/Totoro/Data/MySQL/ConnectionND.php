<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 14:01
 */

namespace Totoro\Data\MySQL;

use Totoro\Data\Common\ConnectionConfig;
use Totoro\Data\Common\IConnection;
use Totoro\Data\Exception\DatabaseException;

class ConnectionND implements IConnection
{
    private $config;
    protected $conn;
    protected $comm;

    public function __construct(ConnectionConfig $config)
    {
        $this->config = $config;
        $this->conn = @mysqli_connect(
            $this->config->getPersistent() ? 'p:' : '' . $this->config->getHost(),
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->config->getDbname(),
            $this->config->getPort()
        );
        if (mysqli_connect_errno()) {
            throw new DatabaseException(DatabaseException::CONNECT_ERR, mysqli_connect_error(), mysqli_connect_errno());
        }
    }

    public function getCommand()
    {
        if (!$this->comm) {
            $this->comm = new CommandND($this);
        }
        return $this->comm;
    }

    public function reConnect()
    {
        return mysqli_real_connect(
            $this->conn,
            $this->config->getPersistent() ? 'p:' : '' . $this->config->getHost(),
            $this->config->getUsername(),
            $this->config->getPassword(),
            $this->config->getDbname(),
            $this->config->getPort()
        );
    }

    public function getRealConnection()
    {
        return $this->conn;
    }
}