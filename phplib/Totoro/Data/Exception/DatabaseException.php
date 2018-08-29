<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 14:15
 */

namespace Totoro\Data\Exception;


use Throwable;

class DatabaseException extends \Exception
{
    const CONNECT_ERR = 'connect';
    const QUERY_ERR = 'query';
    const STATEMENT_ERR = 'statement';

    private $type;

    public function __construct($type, $message = "", $code)
    {
        parent::__construct($message, $code);
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

}