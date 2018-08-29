<?php
/**
 * User: Major
 * Date: 2018/4/19
 * Time: 23:04
 */

namespace Totoro\Data\Common;

interface ITransactable
{
    public function usingTransactionWithTag($tag);
    public function getTransactionTag();
}