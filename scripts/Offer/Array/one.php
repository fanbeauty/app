<?php

/**
 * 输入一个矩阵，按照从外向里以顺时针的顺序依次打印出每一个数字，
 * 例如，如果输入如下4 X 4矩阵：
 * 1 2 3 4
 * 5 6 7 8
 * 9 10 11 12
 * 13 14 15 16
 *
 * 则依次打印出数字1,2,3,4,8,12,16,15,14,13,9,5,6,7,11,10.
 */

$matrix = [
    [1, 2, 3, 4],
    [5, 6, 7, 8],
    [9, 10, 11, 12],
    [13, 14, 15, 16],
    [17, 18, 19, 20],
    [21, 22, 23, 24],
];

function printMatrix($matrix)
{
    $rows = count($matrix);
    $cols = count($matrix[0]);

    if (empty($matrix)) {
        return [];
    }

    $start = 0;
    $result = [];

    while ($rows > $start * 2 && $cols > $start * 2) {
        $result = array_merge($result, printMatrixInCircle($matrix, $rows, $cols, $start));
        $start++;
    }
    return $result;
}

function printMatrixInCircle($matrix, $rows, $cols, $start)
{
    $endX = $cols - $start - 1;
    $endY = $rows - $start - 1;
    $result = [];

    for ($i = $start; $i <= $endX; $i++) {
        $result[] = $matrix[$start][$i];
    }

    if ($start < $endY) {
        for ($i = $start + 1; $i <= $endY; $i++) {
            $result[] = $matrix[$i][$endX];
        }
    }

    if ($start < $endX && $start < $endY) {
        for ($i = $endX - 1; $i >= $start; $i--) {
            $result[] = $matrix[$endY][$i];
        }
    }

    if ($start < $endY && $endY - 1 > $start) {
        for ($i = $endY - 1; $i >= $start + 1; $i--) {
            $result[] = $matrix[$i][$start];
        }
    }

    return $result;
}

print_r(printMatrix($matrix));