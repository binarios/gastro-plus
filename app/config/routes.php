<?php

return [
    'home' => [
        'pattern' => '/',
        'method' => 'GET',
        'action' => 'home@index'
    ],
    'about' => [
        'pattern' => '/about/miao',
        'method' => 'GET',
        'action' => 'home@index',
        "middleware" => ["auth"],
    ],
    'contact' => [
        'pattern' => '/contact',
        'method' => 'GET'
    ]
];
