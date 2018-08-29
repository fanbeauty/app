<?php
/**
 * User: Major
 * Date: 2018/8/27
 * Time: 23:03
 */

/**
 * 把一个数组最开始的若干个元素搬到数组的末尾，我们称之为数组的旋转。 输入一个非减排序的数组的一个旋转，输出旋转数组的最小元素。
 * 例如数组{3,4,5,1,2}为{1,2,3,4,5}的一个旋转，该数组的最小值为1。 NOTE：给出的所有元素都大于0，若数组大小为0，请返回0。
 */

/**
 * {4,5,6,7,8,9,1,2,3}
 */

/**
 * 1. 4 a[4] = 8  8 > 4 , 所有8在左边递增队列中 i = 8
 * 2. 6 a[6] = 1 ,则 1 是在右边的递增队列中 j = 1
 * 3  5 a[5] = 9
 */

function minNumberInRotateArray($rotateArray)
{
    $i = 0;
    $j = count($rotateArray) - 1;
    while ($i + 1 < $j) {
        $center = floor(($i + $j) / 2);
        if ($rotateArray[$center] > $rotateArray[$i]) {
            $i = $center;
        }
        if ($rotateArray[$center] < $rotateArray[$j]) {
            $j = $center;
        }
    }
    return $rotateArray[$j];
}

$arr = [1, 0, 1, 1, 1, 1];

echo minNumberInRotateArray($arr);
