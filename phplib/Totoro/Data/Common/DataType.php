<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 21:16
 */

namespace Totoro\Data\Common;

class DataType
{
    const BIT = 'bit';
    const TINY_INT = 'tinyint';
    const SMALL_INT = 'smallint';
    const MEDIUM_INT = 'mediumint';
    const INT = 'int';
    const BIG_INT = 'bigint';

    const FLOAT = 'float';
    const DOUBLE = 'double';
    const DECIMAL = 'decimal';
    const NUMERIC = 'numeric';

    const DATE = 'date';
    const TIME = 'time';
    const DATE_TIME = 'datetime';
    const TIMESTAMP = 'timestamp';
    const YEAR = 'year';

    const CHAR = 'char';
    const VAR_CHAR = 'varchar';
    const TINY_TEXT = 'tinytext';
    const TEXT = 'text';
    const MEDIUM_TEXT = 'mediumtext';
    const LONG_TEXT = 'longtext';

    const ENUM = 'enum';
    const SET = 'set';

    const BINARY = 'binary';
    const VAR_BINARY = 'varbinary';
    const TINY_BLOB = 'tinyblob';
    const BLOB = 'blob';
    const MEDIUM_BLOB = 'mediumblob';
    const LONG_BLOB = 'longblob';
}