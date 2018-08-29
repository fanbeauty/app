<?php
/**
 * 找出n个数里最小的k个
 */

$a = fgets(STDIN);

$b = explode(' ',$a);

$k = $b[count($b) - 1];

array_pop($b);

sort($b);

