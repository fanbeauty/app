<?php
/**
 * User: Major
 * Date: 2018/4/15
 * Time: 10:37
 */
/**
 * 先是获取输入的字符
 */
//n来表示几组数
fscanf(STDIN, "%d", $m);

//$all 用来存输入的数据
$all = [];
for ($i = 0; $i < $m; $i++) {
    fscanf(STDIN, "%[^\n]s", $line);
    $all[] = explode(" ", trim($line));
}

/**
 * [[1,2],[2,3]]
 */

//找过keys和相等

foreach ($all as $v) {

}
