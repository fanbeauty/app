<?php

/**
 * Class MergeSort
 * 归并排序
 */

class MergeSort
{
    public function __construct(array $arr)
    {
        $this->mSort($arr, 0, count($arr) - 1);
        print_r($arr);
    }

    public function mSort(&$arr, $left, $right)
    {
        if ($left < $right) {
            $center = floor(($left + $right) / 2);
            $this->mSort($arr, $left, $center);
            $this->mSort($arr, $center + 1, $right);
            $this->mergeArray($arr, $left, $center, $right);
        }
    }

    public function mergeArray(&$arr, $left, $center, $right)
    {
        echo '| ' . $left . ' - ' . $center . ' - ' . $right . ' - ' . implode(',', $arr) . PHP_EOL;
        //设置两个起始位置标记
        $a_i = $left;
        $b_i = $center + 1;
        $temp = [];

        while ($a_i <= $center && $b_i <= $right) {
            if ($arr[$a_i] < $arr[$b_i]) {
                $temp[] = $arr[$a_i++];
            } else {
                $temp[] = $arr[$b_i++];
            }
        }

        while ($a_i <= $center) {
            $temp[] = $arr[$a_i++];
        }

        while ($b_i <= $right) {
            $temp[] = $arr[$b_i++];
        }

        for ($i = 0, $len = count($temp); $i < $len; $i++) {
            $arr[$left + $i] = $temp[$i];
        }
    }
}

new MergeSort([4, 7, 6, 3, 9, 5, 8]);
