<?php
/**
 * User: Major
 * Date: 2018/4/9
 * Time: 19:58
 */
//接受n
fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%[^\n]s", $line);
$cases = explode(" ", trim($line));
//遍历
$sum = 0;
for ($i = 0; $i < $n; $i++) {
    $fields = explode(":", $cases[$i]);
    if (intval($fields[0]) > 24 || intval($fields[0]) < 0 || intval($fields[1]) >= 60 || intval($fields[1]) < 0) {
        continue;
    }
    if ($fields[0][0] == $fields[1][1] && $fields[0][1] == $fields[1][0] || $fields[0][0] == $fields[0][1] && $fields[1][0] == $fields[1][1] || $fields[0] == $fields[1]) {
        $sum++;
    }
}
echo $sum;