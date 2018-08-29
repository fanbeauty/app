<?php
/**
 * User: Major
 * Date: 2018/4/5
 * Time: 16:33
 */
/**
 * 1 2
 * 100 3
 * 100 2
 * 100 1
 */
//接受输入的数组
fscanf(STDIN, "%[^\n]s", $line);
$numbers = explode(' ', trim($line));
$machineNumbers = intval($numbers[0]);
$taskNumbers = intval($numbers[1]);

$machines = array();
$tasks = array();
for ($i = 0; $i < $machineNumbers; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $temp1 = explode(' ', trim($line));
    $machines[] = $temp1;
}
for ($j = 0; $j < $taskNumbers; $j++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $temp2 = explode(' ', trim($line));
    $tasks[] = $temp2;
}
/**
 *
 * 规律：
 * 机器 100 3
 * 任务 100 2 100 1
 * 先看等级，3表示都可以做，再来看时间
 */

$total = 0;
$totalUserful = 0;
for ($k = 0; $k < count($machines); $k++) {
    $time = intval($machines[$k][0]);
    $hard = intval($machines[$k][1]);
    $userful = 0; //表示效益
    for ($n = 0; $n < count($tasks); $n++) {
        $tasktime = intval($tasks[$n][0]);
        $taskhard = intval($tasks[$n][1]);
        $tempUserful = 200 * $tasktime + 3 * $taskhard;
        //处理
        if ($hard >= $taskhard && $time <= $tasktime && $userful < $tempUserful) {
            $userful = $tempUserful;
        }
    }
    $totalUserful += $userful;
}

$total = floor($totalUserful / 300);

echo $total.' '.$totalUserful;





















