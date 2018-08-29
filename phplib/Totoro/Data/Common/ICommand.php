<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 14:29
 */

namespace Totoro\Data\Common;

interface ICommand
{
    public function __construct(IConnection $connection);

    /**
     * escapeString
     */
    public function escapeString($str);

    /**
     * executeNonQuery 执行没有返回的sql
     * @return int 影响的函数
     */
    public function executeNonQueryBySql($sql);

    /*
     * executeScalar 执行只返回一个值的sql语句
     */
    public function executeScalarBySql($sql);

    /*
     *  executeDataReader 执行返回数组的sql语句，以IDataReader返回数据集
     */
    public function executeDataReaderBySql($sql);

    /*
     * executeNonQuery 执行没有返回的 statement
     */
    public function executeNoneQuery($sql, array $type_array, array $param_array);

    /*
     * executeScalar 执行返回一个值的 statement
     */
    public function executeScalar($sql, array $type_array, array $param_array);

    /*
     * executeDataSet 执行返回数组的statement
     */
    public function executeDataSet($sql, array $type_array, array $param_array);

    /*
     * executeDataReader 执行返回数组的statement 以IDataReader返回结果集
     */
    public function executeDataReader($sql, array $type_array, array $param_array);

    /**
     * lastInsertId 获取最新一次的写入id
     */
    public function lastInsertId();

    /**
     * begin 开启事务
     */
    public function begin();

    /**
     * commit 提交
     */
    public function commit();

    /**
     * rollback 回滚
     */
    public function rollback();

}