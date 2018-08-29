<?php
/**
 * User: Major
 * Date: 2018/4/20
 * Time: 16:03
 */

namespace Totoro\Data\Common;

use Totoro\Data\Exception\DatabaseException;
use Totoro\Data\TableDefinition;

class SqlAssember
{
    private $commander;

    public function __construct(ICommand $commander)
    {
        $this->commander = $commander;
    }

    private function genSelectExpr($filed_list)
    {
        $select_expr = '';
        if (!is_array($filed_list)) {
            $filed_list = [$filed_list];
        }
        foreach ($filed_list as $filed) {
            if (preg_match('/(\w+)(?:\s+AS\s+(\w+))?/i', $filed, $matches) == 1) {
                if (!empty($matches[2])) {
                    $select_expr .= "`{$matches[1]}` AS `{$matches[2]}`, ";
                } else {
                    $select_expr .= "`{$matches[1]}`, ";
                }
            }
        }
        $select_expr = substr($select_expr, 0, -2);
        return $select_expr;
    }

    private function genWhereClause(array $where_map)
    {
        $where_clause = '';
        foreach ($where_map as $field_expr => $value) {
            if (preg_match('/(\w+)\s*([<>=]*)/i', $field_expr, $matches)) {
                $field = $matches[1];
                $op = $matches[2] ? $matches[2] : '=';
                $value = $this->commander->escapeString($value);
                $where_clause .= "`{$field}` {$op} '{$value}' AND";
            } else {
                throw new DatabaseException(
                    DatabaseException::QUERY_ERR,
                    '请求查询语法错误',
                    0
                );
            }
        }
        if ($where_clause) {
            $where_clause = ' WHERE ' . substr($where_clause, 0, -4);
        }
        return $where_clause;
    }

    public function genSelectSql($field_list, TableDefinition $table_definition, array $where_map, $orderby_expr = null, $offset_limit = null, $limit = null)
    {
        //准备查询的内容
        $select_expr = $this->genSelectExpr($field_list);
        $table_name = $table_definition->getTableName();

        //准备 where 查询条件
        $where_clause = $this->genWhereClause($where_map);

        // 准备 orderby
        $orderby_clause = '';
        if ($orderby_expr) {
            $orderby_clause = " ORDER BY {$orderby_expr}";
        }

        //准备 offset_limit
        if ($offset_limit !== null) {
            $offset_clause = ' LIMIT ' . intval($offset_limit);
            if ($limit) {
                $offset_clause .= ', ' . intval($limit);
            }
        }
        $sql = "SELECT {$select_expr} FROM {$table_name} {$where_clause}{$orderby_clause}{$offset_clause}";
        return $sql;
    }

    public function genSelectCountSql($field_as, TableDefinition $table_definition, array $where_map)
    {
        $table_name = $table_definition->getTableName();
        $where_clause = $this->genWhereClause($where_map);
        $sql = "SELECT COUNT(*) AS {$field_as} FROM {$table_name} WHERE {$where_clause}";
        return $sql;
    }

    private function genSetExpr(array $data_set)
    {
        $set_expr = '';
        foreach ($data_set as $field => $value) {
            if (preg_match('/^\w+$/', $field, $matches) == 1) {
                $value = $this->commander->escapeString($value);
                $set_expr .= "`{$field}` = '{$value}', ";
            } else {
                throw new DatabaseException(
                    DatabaseException::QUERY_ERR,
                    '请求查询语法错误',
                    0
                );
            }
        }
        if ($set_expr) {
            $set_expr = substr($set_expr, 0, -2);
        }
        return $set_expr;
    }

    public function genInsertSql(TableDefinition $table_definition, array $data_set)
    {
        $table_name = $table_definition->getTableName();
        $set_expr = $this->genSetExpr($data_set);
        $sql = "INSERT INTO `{$table_name}` SET {$set_expr}";
        return $sql;
    }

    public function genReplaceSql(TableDefinition $table_definition, array $data_set)
    {
        $table_name = $table_definition->getTableName();
        $set_expr = $this->genSetExpr($data_set);
        $sql = "REPLACE INTO `{$table_name}` SET {$set_expr}";
        return $sql;
    }

    public function genUpdateSql(TableDefinition $table_definition, array $data_set, array $where_map, $limit = null)
    {
        $table_name = $table_definition->getTableName();
        $set_expr = $this->genSetExpr($data_set);
        $where_clause = $this->genWhereClause($where_map);
        if ($limit !== null) {
            $limit_clause = ' LIMIT ' . intval($limit);
        } else {
            $limit_clause = '';
        }
        $sql = "UPDATE `{$table_name}` SET {$set_expr}{$where_clause}{$limit_clause}";
        return $sql;
    }

    public function genDeleteSql(TableDefinition $table_definition, array $where_map, $limit = null)
    {
        $table_name = $table_definition->getTableName();
        $where_clause = $this->genWhereClause($where_map);
        if ($limit !== null) {
            $limit_clause = ' LIMIT ' . intval($limit);
        } else {
            $limit_clause = '';
        }
        $sql = "DELETE FROM `{$table_name}`{$where_clause}{$limit_clause}";
        return $sql;
    }

    private function genWhereStmtParams(TableDefinition $table_definition, array $where_map)
    {
        $where_clause = '';
        $type_array = array();
        $value_array = array();
        foreach ($where_map as $field_expr => $value) {
            if (preg_match('/(\w+)\s*([<>=]*)/', $field_expr, $matches) == 1) {
                $field = $matches[1];
                $op = $matches[2] ? $matches[2] : '=';
                $value = $this->commander->escapeString($value);
                $where_clause .= "`{$field}` {$op} ? AND ";
                $type = $table_definition->getFieldType($field);
                if (!$type) {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        '请求查询语法错误',
                        0
                    );
                }
                $type_array[] = $type;
                $value_array[] = $value;
            } else {
                throw new DatabaseException(
                    DatabaseException::QUERY_ERR,
                    '请求查询语法错误',
                    0
                );
            }
        }
        if ($where_clause) {
            $where_clause = ' WHERE ' . substr($where_clause, 0, -5);
        }
        return array(
            'where_clause' => $where_clause,
            'type_array' => $type_array,
            'value_array' => $value_array
        );
    }

    public function genSelectSqlStmtParams($field_list, TableDefinition $table_definition, array $where_map, $orderby_expr = null, $offset_limit = null, $limit = null)
    {
        $select_expr = $this->genSelectExpr($field_list);
        $table_name = $table_definition->getTableName();
        $where_params = $this->genWhereStmtParams($table_definition, $where_map);
        $where_clause = $where_params['where_clause'];
        $type_array = $where_params['type_array'];
        $value_array = $where_params['value_type'];

        $orderby_clause = '';
        if ($orderby_expr !== null) {
            $orderby_clause = ' ORDER BY ' . $orderby_expr;
        }

        $limit_clause = '';
        if ($offset_limit !== null) {
            $limit_clause = ' LIMIT ' . intval($offset_limit);
            if ($limit) {
                $limit_clause .= ',' . intval($limit);
            }
        }

        $sql = "SELECT {$select_expr} FROM {$table_name} {$where_clause}{$orderby_clause}{$limit_clause}";

        return array(
            'sql' => $sql,
            'type_array' => $type_array,
            'value_type' => $value_array
        );
    }

    public function getSelectCountPrams($field_as, TableDefinition $table_definition, array $where_map)
    {
        $table_name = $table_definition->getTableName();
        $where_params = $this->genWhereStmtParams($table_definition, $where_map);
        $where_clause = $where_params['where_clause'];
        $type_array = $where_params['type_array'];
        $value_array = $where_params['value_type'];

        $sql = "SELECT COUNT(*) AS {$field_as} FROM {$table_name}{$where_clause}";
        return array(
            'sql' => $sql,
            'type_array' => $type_array,
            'value_type' => $value_array
        );
    }

    public function genSetStmtParams(TableDefinition $table_definition, array $data_set)
    {
        $set_expr = '';
        $type_array = array();
        $value_array = array();

        foreach ($data_set as $filed => $value) {
            if (preg_match('/^\w+$/', $filed) == 1) {
                $set_expr .= "`{$filed}` = ?, ";
                $type = $table_definition->getFieldType($filed);
                if (!$type) {
                    throw new DatabaseException(
                        DatabaseException::QUERY_ERR,
                        '请求查询语法错误',
                        0
                    );
                }
                $value = $this->commander->escapeString($value);
                $type_array[] = $type;
                $value_array[] = $value;
            } else {
                throw new DatabaseException(
                    DatabaseException::QUERY_ERR,
                    '请求查询语法错误',
                    0
                );
            }
        }

        if ($set_expr) {
            $set_expr = substr($set_expr, 0, -2);
        }
        return array(
            'set_expr' => $set_expr,
            'type_array' => $type_array,
            'value_array' => $value_array
        );
    }

    public function genInsertSqlStmtParams(TableDefinition $table_definition, array $data_set)
    {
        $table_name = $table_definition->getTableName();
        $set_params = $this->genSetStmtParams($table_definition, $data_set);
        $set_expr = $set_params['set_expr'];
        $type_array = $set_params['type_array'];
        $value_array = $set_params['value_array'];

        $sql = "INSERT INTO  `{$table_name}` SET {$set_expr}";

        return array(
            'sql' => $sql,
            'type_array' => $type_array,
            'value_array' => $value_array
        );
    }

    public function genUpdateSqlStmtParams(TableDefinition $table_definition, array $data_set, array $where_map, $limit = null)
    {
        $table_name = $table_definition->getTableName();

        // 准备数据插入语句
        $set_params = $this->genSetStmtParams($table_definition, $data_set);
        $set_expr = $set_params['set_expr'];
        $set_type_array = $set_params['type_array'];
        $set_value_array = $set_params['value_array'];

        // 准备 where 查询条件
        $where_params = $this->genWhereStmtParams($table_definition, $where_map);
        $where_clause = $where_params['where_clause'];
        $where_type_array = $where_params['type_array'];
        $where_value_array = $where_params['value_array'];

        // 准备 offset limit
        if ($limit !== null) {
            $limit_clause = " LIMIT " . intval($limit);
        }

        $sql = "UPDATE `{$table_name}` SET {$set_expr}{$where_clause}{$limit_clause}";

        return array(
            'sql' => $sql,
            'type_array' => array_merge($set_type_array, $where_type_array),
            'value_array' => array_merge($set_value_array, $where_value_array),
        );
    }

    public function genDeleteSqlStmtParams(TableDefinition $table_definition, array $where_map, $limit = null)
    {
        $table_name = $table_definition->getTableName();

        // 准备 where 查询条件
        $where_params = $this->genWhereStmtParams($table_definition, $where_map);
        $where_clause = $where_params['where_clause'];
        $where_type_array = $where_params['type_array'];
        $where_value_array = $where_params['value_array'];

        // 准备 offset limit
        if ($limit !== null) {
            $limit_clause = " LIMIT " . intval($limit);
        }

        $sql = "DELETE FROM `{$table_name}`{$where_clause}{$limit_clause}";

        return array(
            'sql' => $sql,
            'type_array' => $where_type_array,
            'value_array' => $where_value_array,
        );
    }

    public function genReplaceSqlStmtParams(TableDefinition $table_definition, array $data_set)
    {
        $table_name = $table_definition->getTableName();

        // 准备数据插入语句
        $set_params = $this->genSetStmtParams($table_definition, $data_set);
        $set_expr = $set_params['set_expr'];
        $type_array = $set_params['type_array'];
        $value_array = $set_params['value_array'];

        $sql = "REPLACE INTO `{$table_name}` SET {$set_expr}";

        return array(
            'sql' => $sql,
            'type_array' => $type_array,
            'value_array' => $value_array,
        );
    }
}

