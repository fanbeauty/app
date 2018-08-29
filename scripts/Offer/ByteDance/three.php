<?php

fscanf(STDIN, "%d", $m);
$result = [];

for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%d", $len);

    $strs = [];
    for ($j = 0; $j < $len; $j++) {
        fscanf(STDIN, "%s", $strs[$j]);
    }

    $bool = false;
    $flag = false;
    for ($k = 0; $k < count($strs); $k++) {
        $tmp = $strs[$k];
        for ($n = $k + 1; $n < count($strs); $n++) {
            $bool = isContain($tmp, $strs[$n]);
            if ($bool && !$flag) {
                array_push($result, "Yeah");
                $flag = true;
                break;
            }
        }
    }
    if (!$bool && !$flag) {
        array_push($result, "Sad");
    }

}

//打印结果
for ($i = 0; $i < count($result) - 1; $i++) {
    echo $result[$i] . PHP_EOL;
}
echo array_pop($result);


//判断s1,s2是否是变位词
function isContain($s1, $s2)
{
    if (empty($s2)) {
        return false;
    }
    $s3 = str_repeat($s2, 2);
    if (strpos($s3, $s1) !== false
        || strpos($s3, strrev($s1)) !== false
    ) {
        return true;
    } else {
        return false;
    }
}