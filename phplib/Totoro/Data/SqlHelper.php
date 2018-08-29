<?php
/**
 * User: Major
 * Date: 2018/4/21
 * Time: 16:43
 */

namespace Totoro\Data;

use Totoro\Data\Common\ITransactable;
use Totoro\Data\Common\ServerType;
use Totoro\Data\Common\SqlAssember;

class SqlHelper implements ITransactable
{
    private $tableDefinition = null;
    private $commander;
    private $transactionTag = null;

    public function __construct(TableDefinition $tableDefinition)
    {
        $this->tableDefinition = $tableDefinition;
        $this->commander = new Commander($tableDefinition->getConnector());
    }

    public function usingTransactionWithTag($tag)
    {
        $this->commander->usingTransactionWithTag($tag);
    }

    public function getTransactionTag()
    {
        return $this->transactionTag;
    }

    /*
     * by sql
     */
    public function selectBySql($field_list, array $where_map, $orderby_expr = null, $offset_limit = null, $limit = null, $server_type = ServerType::SLAVE)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genSelectSql(
            $field_list,
            $table_definition,
            $where_map,
            $orderby_expr,
            $offset_limit,
            $limit
        );
        return $commander->getAllBySql($sql, $server_type);
    }

    public function selectForUpdateBySql($field_list, array $where_map, $orderby_expr = null, $offset_limit = null, $limit = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genSelectSql(
            $field_list,
            $table_definition,
            $where_map,
            $orderby_expr,
            $offset_limit,
            $limit
        );
        return $commander->getAllBySql($sql . ' FOR UPDATE', ServerType::MASTER);
    }

    public function selectCountBySql(array $where_map, $server_type = ServerType::SLAVE)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genSelectCountSql('s', $table_definition, $where_map);
        $result = $commander->getRowBySql($sql, $server_type);
        return $result;
    }

    public function insertBySql(array $data_set)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genInsertSql($table_definition, $data_set);
        return $commander->executeBySql($sql);
    }

    public function insertBySqlWithLastInsertId(array $data_set, &$lastInsertId = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genInsertSql($table_definition, $data_set);
        $commander->executeBySqlWithLastInsertId($sql, $lastInsertId);
        return $lastInsertId;
    }

    public function updateBySql(array $data_set, array $where_map, $limit = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genUpdateSql($table_definition, $data_set, $where_map, $limit);
        return $commander->executeBySql($sql);
    }

    public function deleteBySql(array $where_map, $limit = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genDeleteSql($table_definition, $where_map, $limit);
        return $commander->executeBySql($sql);
    }

    public function replaceBySql(array $data_set)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $sql = $assember->genReplaceSql($table_definition, $data_set);
        return $commander->executeBySql($sql);
    }

    /*
     * statement
     */
    public function select($field_list, array $where_map, $orderby_expr = null, $offset_limit = null, $limit = null, $server_type = ServerType::SLAVE)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genSelectSqlStmtParams(
            $field_list, $table_definition, $where_map, $orderby_expr, $offset_limit, $limit
        );
        return $commander->getAll(
            $params['sql'],
            $params['type_array'],
            $params['value_array'],
            $server_type
        );
    }

    public function selectForUpdate($field_list, array $where_map, $orderby_expr = null, $offset_limit = null, $limit = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genSelectSqlStmtParams(
            $field_list, $table_definition, $where_map, $orderby_expr, $offset_limit, $limit
        );
        return $commander->getAll(
            $params['sql'] . ' FOR UPDATE',
            $params['type_array'],
            $params['value_array'],
            ServerType::MASTER
        );
    }

    public function selectCount(array $where_map, $server_type = ServerType::SLAVE)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->getSelectCountPrams('s', $table_definition, $where_map);
        $result = $commander->getRow(
            $params['sql'],
            $params['type_array'],
            $params['value_array']
        );
        return intval($result['s']);
    }

    public function insert(array $data_set)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genInsertSqlStmtParams($table_definition, $data_set);
        return $commander->execute(
            $params['sql'],
            $params['type_array'],
            $params['value_array']
        );
    }

    public function insertForId(array $data_set)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genInsertSqlStmtParams($table_definition, $data_set);
        $rtn = $commander->executeWithLastInsertId(
            $params['sql'],
            $params['type_array'],
            $params['value_array'],
            $lastInsertId
        );
        return $lastInsertId;
    }

    public function update(array $data_set, array $where_map, $limit = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genUpdateSqlStmtParams($table_definition, $data_set, $where_map, $limit);
        return $commander->execute(
            $params['sql'],
            $params['type_array'],
            $params['value_array']
        );
    }

    public function delete(array $where_map, $limit = null)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genDeleteSqlStmtParams($table_definition, $where_map, $limit);
        return $commander->execute(
            $params['sql'],
            $params['type_array'],
            $params['value_array']
        );
    }

    public function replace(array $data_set)
    {
        $table_definition = $this->tableDefinition;
        $commander = $this->commander;
        $assember = new SqlAssember($commander);
        $params = $assember->genReplaceSqlStmtParams($table_definition, $data_set);
        return $commander->execute(
            $params['sql'],
            $params['type_array'],
            $params['value_array']
        );
    }
}
