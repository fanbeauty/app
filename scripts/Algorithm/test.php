<?php
//$n表示转的方向次数
fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%[^\n]s", $line);
$actions = str_split(trim($line));
//可以先定义一个数组，存储最后的方向 0 ->北 1->东 2->南 3->西
$directions = ['N', 'E', 'S', 'W'];
$init = 0; // 北方
foreach ($actions as $action) {
    if ($action == "L") {
        $init = $init - 1 < 0 ? $init + 4 - 1 : $init - 1;
    } else if ($action == "R") {
        $init = $init + 1 > 3 ? $init - 4 + 1 : $init + 1;
    }
}
//输出最后的方向
echo $directions[$init];