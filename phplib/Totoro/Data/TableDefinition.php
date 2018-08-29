<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 23:58
 */

namespace Totoro\Data;

abstract class TableDefinition
{
    abstract public function getConnector();

    abstract public function getTableName();

    abstract public function isAutoIncreSinglePK();

    abstract public function getPrimaryKeyList();

    abstract public function getUniqueKeyArray();

    abstract public function getFieldList();

    abstract public function getFieldType($field_name);

    abstract public function getFieldLength($field_name);

    abstract public function getFieldPermittedValues($field_name);

    abstract public function getFieldIsNull($field_name);

    abstract public function getFieldKeyType($field_name);

    abstract public function getFieldDefault($field_name);

    abstract public function getFieldExtra($field_name);

    abstract public function doCache();

    abstract public function getICache();

    abstract protected function getCacheKeyPrefix();

    abstract public function getCacheExpire();
}
