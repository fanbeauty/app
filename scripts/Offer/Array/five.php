<?php

//n来表示几组数
fscanf(STDIN, "%d", $n);
//$arr 用来存输入的数据
$arr = array();
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $arr[] = explode(" ", trim($line));
}

list($count, $pos) = cancer($arr);

if ($count == 0) {
    echo 0;
    echo "\n";
} else if ($count == 1) {
    echo $count;
    echo "\n";
    echo $pos + 1;
    echo "\n";
} else {
    echo $count;
    echo "\n";
    for ($i = 1; $i <= $count; $i++) {
        echo $i . ' ';
    }
    echo "\n";
}


function cancer($arr)
{
    $count = count($arr);
    $localPos = 0;

    $mustBeCancer = 0;
    for ($i = 0; $i < $count; $i++) {

        $firstMin = $arr[$i][0];
        $firstMax = $arr[$i][1];
        $dur1 = $firstMax - $firstMin;

        for ($j = $i + 1; $j < $count; $j++) {
            $dur2 = $arr[$j][1] - $arr[$j][0];
            if (($arr[$j][0] > $firstMin && $arr[$j][0] < $firstMax)
                || ($arr[$j][1] > $firstMin && $arr[$j][1] < $firstMax)
            ) {
                if ($dur2 >= $dur1) {
                    $mustBeCancer++;
                    $localPos = $j;
                } else {
                    $mustBeCancer++;
                    $localPos = $i;
                }
            }

            if ($mustBeCancer == 2) {
                return 0;
            }
        }
    }

    if ($mustBeCancer == 1) {
        return [1, $localPos];
    }

    if ($mustBeCancer == 0) {
        return [$count, $count];
    }
}
