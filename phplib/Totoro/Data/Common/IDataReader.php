<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 18:29
 */

namespace Totoro\Data\Common;

interface IDataReader
{
    /*
     * read 读取一行数据，并向后移动数据指针
     */
    public function read();

    /**
     * 返回当前数据集字段的数量
     */
    public function getNumFields();

    /*
     * 返回当前数据集的行数
     */
    public function getNumRows();

    /*
     * 释放当前数据集
     */
    public function dispose();

}