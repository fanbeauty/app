<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 15:42
 */

namespace App\Data;

use App\Data\Common\ConsistencyHash;
use App\Util\Times33;

class Memcached implements ConsistencyHash
{
    private $server_list = array();

    private $is_sorted = false;

    public function addServer($server)
    {
        $hash = Times33::getHash($server);
        if (!isset($this->server_list[$hash])) {
            $this->server_list[$hash] = $server;
        }
        $this->is_sorted = false;
        return true;
    }

    public function removeServer($server)
    {
        $hash = Times33::getHash($server);
        if (isset($this->server_list[$hash])) {
            unset($this->server_list[$hash]);
        }
        $this->is_sorted = false;
        return true;
    }

    public function lookup($key)
    {
        $hash = Times33::getHash($key);
        if (!$this->is_sorted) {
            krsort($this->server_list, SORT_NUMERIC);
            $this->is_sorted = true;
        }
        foreach ($this->server_list as $pos => $server) {
            if ($hash > $pos) return $server;
        }
        return $this->server_list[count($this->server_list) - 1];
    }
}
