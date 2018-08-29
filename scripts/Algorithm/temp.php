<?php
/**
 * User: Major
 * Date: 2018/4/5
 * Time: 16:04
 */

function methods($sum, $k)
{
    $sum1 = 1;
    $sum2 = 1;
    for($i=0;$i<$k;$i++)
    {
        $sum1 *=($sum-$i);
        $sum2 *=($i+1);
    }
    return $sum1/$sum2;
}


echo methods(10,3);