<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 23:02
 */

namespace Totoro\Data\Common;

class ServerType
{
    const MASTER = 'master';
    const SLAVE = 'slave';
    const BACKUP = 'backup';
    const TRANSACTION = 'transaction';
}