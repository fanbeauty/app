<?php
/**
 * User: Major
 * Date: 2018/4/28
 * Time: 0:06
 */

class QuickSort
{
    public function __construct(array $arr)
    {
        $sorted = $this->quickSort($arr);
        print_r($sorted);
    }

    // 3 4 2 1 5 8 9
    // 以3为几点
    public function quickSort($arr)
    {
        $count = count($arr);
        if ($count <= 1) {
            return $arr;
        }
        $first = $arr[0];
        $left = $right = [];
        for ($i = 1; $i < $count; $i++) {
            if ($arr[$i] <= $first) $left[] = $arr[$i];
            else $right[] = $arr[$i];
        }
        $left = $this->quickSort($left);
        $right = $this->quickSort($right);
        return array_merge($left, [$first], $right);
    }

}

new QuickSort([3, 2, 1, 5, 7, 8, 4, 9]);
