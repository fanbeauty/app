<?php

$sourceArr = [
    [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8
    ],
    [
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8
    ]
];

$key = [ 'five', 'two','eight',"one"];

$datas = [];
foreach ($sourceArr as $item) {
    $datas[] = array_filter($item, function ($index) use ($key) {
        if (in_array($index, $key)) {
            return true;
        } else {
            return false;
        }
    }, ARRAY_FILTER_USE_KEY);


}
var_dump($datas);





