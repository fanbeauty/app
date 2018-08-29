<?php

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%[^\n]s", $line);
$arr = explode(" ", trim($line));

sort($arr);

array_shift($arr);

echo array_sum($arr);