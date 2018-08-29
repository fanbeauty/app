<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 18:33
 */

namespace Totoro\Data\MySQL;

use Totoro\Data\Common\IDataReader;

class MySQLDataReader implements IDataReader
{
    private $res = null;

    /**
     * MySQLDataReader constructor.
     * @param $res
     */
    public function __construct(\mysqli_result $res)
    {
        $this->res = $res;
    }


    public function read()
    {
        if ($this->res != null) {
            $row = mysqli_fetch_array($this->res, MYSQLI_ASSOC);
            if ($row != null)
                return $row;
            else
                return false;
        }
    }

    public function getNumFields()
    {
        if ($this->res != null) {
            return mysqli_num_fields($this->res);
        }
    }

    public function getNumRows()
    {
        if ($this->res != null) {
            return mysqli_num_rows($this->res);
        }
    }

    public function dispose()
    {
        if ($this->res != null) {
            mysqli_free_result($this->res);
            $this->res = null;
        }
        return true;
    }
}