<?php
/**
 * User: Major
 * Date: 2018/4/9
 * Time: 20:47
 */

/*fscanf(STDIN, "%s", $str);

function ishuiwen($str)
{
    $i = 0;
    $j = count($str) - 1;
    while ($i < $j) {
        if ($str[$i] == $str[$j]) {
            $i++;
            $j--;
        }
    }
    if (count($str) == 0) return false;
    if ($i == $j) return true;
    return false;
}

if (ishuiwen($str)) {
    $len = count($str);
    echo 2 * $len - 1;
} else {

}*/


class Test{
    public static $a=10;
    public static function test1()
    {
        echo 'helleo';
    }
}
Test::test1();
echo Test::$a;


$n = new Test();
$n->test1();
#$n::test1();











