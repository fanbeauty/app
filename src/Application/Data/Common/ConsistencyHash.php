<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 15:39
 */

namespace App\Data\Common;

interface ConsistencyHash
{
    public function addServer($server);

    public function removeServer($server);

    public function lookup($key);
}