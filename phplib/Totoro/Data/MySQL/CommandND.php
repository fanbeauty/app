<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 18:00
 */

namespace Totoro\Data\MySQL;

use Totoro\Data\Common\DataType;
use Totoro\Data\Common\ICommand;
use Totoro\Data\Common\IConnection;
use Totoro\Data\Exception\DatabaseException;

class CommandND implements ICommand
{
    const MAX_RETRY = 1;

    private $connection;
    private $conn;

    public function __construct(IConnection $connection)
    {
        $this->connection = $connection;
        $this->conn = $connection->getRealConnection();
    }

    public function escapeString($str)
    {
        return mysqli_real_escape_string($this->conn, $str);
    }

    public function executeNonQueryBySql($sql)
    {
        return $this->retry(
            function () use ($sql) {
                if (!@mysqli_query($this->conn, $sql)) {
                    throw new DatabaseException(DatabaseException::QUERY_ERR, mysqli_error($this->conn), mysqli_errno($this->conn));
                } else {
                    return mysqli_affected_rows($this->conn);
                }
            }
        );
    }

    public function executeScalarBySql($sql)
    {
        return $this->retry(
            function () use ($sql) {
                if (!@$res = mysqli_query($this->conn, $sql)) {
                    throw new DatabaseException(DatabaseException::QUERY_ERR, mysqli_error($this->conn), mysqli_errno($this->conn));
                } else {
                    list($scalar) = mysqli_fetch_row($res);
                    return $scalar;
                }
            }
        );
    }

    public function executeDataReaderBySql($sql)
    {
        return $this->retry(
            function () use ($sql) {
                if (@($res = mysqli_query($this->conn, $sql))) {
                    return new MySQLDataReader($res);
                } else {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        mysqli_error($this->conn),
                        mysqli_errno($this->conn)
                    );
                }
            }
        );
    }

    public function execDataSetBySql($sql)
    {
        $this->retry(
            function () use ($sql) {
                $data_set = array();
                if (@($res = mysqli_query($this->conn, $sql))) {
                    while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                        $data_set[] = $row;
                    }
                    mysqli_free_result($res);
                    return $data_set;
                } else {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        mysqli_error($this->conn),
                        mysqli_errno($this->conn)
                    );
                }
            }
        );
    }

    public function prepare($sql, array $type_array, array $param_array)
    {
        return $this->retry(
            function () use ($sql, $type_array, $param_array) {
                $stmt = mysqli_stmt_init($this->conn);
                if (@mysqli_stmt_prepare($stmt, $sql)) {
                    $type_count = count($type_array);
                    $param_count = count($param_array);
                    $count = min($type_count, $param_count);
                    if ($count > 0) {
                        $args = array($stmt, '');
                        for ($i = 0; $i < $count; $i++) {
                            $args[1] .= $this->convertTypeString($type_array[$i]);
                            $args[] = $param_array[$i];
                        }
                        if (!call_user_func_array('mysqli_stmt_bind_param', $args))
                            throw new DatabaseException(DatabaseException::STATEMENT_ERR, $stmt->error, $stmt->errno);
                    }
                    return $stmt;
                } else {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        mysqli_error($this->conn),
                        mysqli_errno($this->conn)
                    );
                }
            }
        );
    }

    public function executeNoneQuery($sql, array $type_array, array $param_array)
    {
        $stmt = $this->prepare($sql, $type_array, $param_array);
        if (mysqli_stmt_execute($stmt)) {
            $affected_rows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            return $affected_rows;
        } else {
            throw new DatabaseException(DatabaseException::CONNECT_ERR, $stmt->error, $stmt->errno);
        }
    }

    public function executeScalar($sql, array $type_array, array $param_array)
    {
        $stmt = $this->prepare($sql, $type_array, $param_array);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_array($res, MYSQLI_ASSOC);
            mysqli_stmt_close($stmt);
            mysqli_free_result($res);
            return $row[0];
        } else {
            throw new DatabaseException(DatabaseException::STATEMENT_ERR, $stmt->error, $stmt->errno);
        }
    }

    public function executeDataSet($sql, array $type_array, array $param_array)
    {
        $stmt = $this->prepare($sql, $type_array, $param_array);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result();
            $data_set = [];
            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $data_set[] = $row;
            }
            mysqli_stmt_close($stmt);
            mysqli_free_result($res);
            return $data_set;
        } else {
            throw new DatabaseException(DatabaseException::STATEMENT_ERR, $stmt->error, $stmt->errno);
        }
    }

    public function executeDataReader($sql, array $type_array, array $param_array)
    {
        $stmt = $this->prepare($sql, $type_array, $param_array);
        if (mysqli_stmt_execute($stmt)) {
            $res = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return new MySQLDataReader($res);
        } else {
            throw new DatabaseException(DatabaseException::STATEMENT_ERR, $stmt->error, $stmt->errno);
        }
    }

    public function lastInsertId()
    {
        $insert_id = mysqli_insert_id($this->conn);
        return $insert_id != -1 ? $insert_id : false;
    }

    public function begin()
    {
        return $this->retry(
            function () {
                if (@mysqli_begin_transaction($this->conn)) {
                    return true;
                } else {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        mysqli_error($this->conn),
                        mysqli_errno($this->conn)
                    );
                }
            }
        );
    }

    public function commit()
    {
        if (@mysqli_commit($this->conn)) {
            return true;
        } else {
            throw new DatabaseException(
                DatabaseException::QUERY_ERR,
                mysqli_error($this->conn),
                mysqli_errno($this->conn)
            );
        }
    }

    public function rollback()
    {
        return $this->retry(
            function () {
                if (@mysqli_rollback($this->conn)) {
                    return true;
                } else {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        mysqli_error($this->conn),
                        mysqli_errno($this->conn)
                    );
                }
            }
        );
    }

    public function retry(\Closure $do)
    {
        $retry = self::MAX_RETRY;
        do {
            try {
                return $do();
            } catch (DatabaseException $e) {
                if ($retry && $e->getCode() == 2006) {
                    $this->conn = $this->connection->reConnect();
                } else {
                    throw $e;
                }
            }
        } while ($retry--);
    }

    private function convertTypeString($type)
    {
        switch ($type) {
            case DataType::BIT:
            case DataType::TINY_INT:
            case DataType::SMALL_INT:
            case DataType::MEDIUM_INT:
            case DataType::INT:
            case DataType::BIG_INT:
                return 'i';

            case DataType::FLOAT:
            case DataType::DOUBLE:
            case DataType::DECIMAL:
            case DataType::NUMERIC:
                return 'd';

            case DataType::DATE:
            case DataType::TIME:
            case DataType::DATE_TIME:
            case DataType::TIMESTAMP:
            case DataType::YEAR:

            case DataType::CHAR:
            case DataType::VAR_CHAR:
            case DataType::ENUM:
            case DataType::SET:
            case DataType::TINY_TEXT:
            case DataType::TEXT:
            case DataType::MEDIUM_TEXT:
            case DataType::LONG_TEXT:
                return 's';

            case DataType::BINARY:
            case DataType::VAR_BINARY:
            case DataType::TINY_BLOB:
            case DataType::BLOB:
            case DataType::MEDIUM_BLOB:
            case DataType::LONG_BLOB:
                return 'b';

            default:
                return 's';
        }
    }
}