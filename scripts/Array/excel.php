<?php

$data_header = ['name' => '姓名', 'age' => '年龄', 'sex' => '性别'];
$data = [
    'user' => [
        [
            'name' => 'huanhuan',
            'age' => 25,
            'sex' => 'girl'
        ],
        [
            'name' => 'ansds',
            'age' => 21,
            'sex' => 'boy'
        ]
    ]
];

$row = 0;
$column = 0;

$dataAll = [];
foreach ($data_header as $key => $value) {
    $dataAll[$row][$column] = $value;
    $column++;
}

foreach ($data['user'] as $user) {
    $column = 0;
    $row++;
    foreach ($user as $value) {
        $dataAll[$row][$column] = $value;
        $column++;
    }
}

var_dump($dataAll);
