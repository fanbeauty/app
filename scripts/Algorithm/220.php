<?=
/**
 * User: Major
 * Date: 2018/4/12
 * Time: 18:13
 */
/*
 * 给定一个整数数组，判断数组中是否有两个不同的索引 i 和 j，
 * 使 nums [i] 和 nums [j] 的绝对差值最大为 t，并且 i 和 j 之间的绝对差值最大为 ķ。
 */
/**
 * 数组去重
 */

$arr = [1, 1, 1, 1, 2, 2, 2, 2, 2, 3, 3, 3, 3, 4, 4, 4, 4, 5, 5, 5, 5, 5];

//$last = array_unique($arr);

$last = array_flip($arr);
$last = array_flip($last);
$last = array_values($last);

var_dump($last);

























