<?php

return [
    'home' => [
        'pattern' => '/',
        'method' => 'GET',
        'action' => 'home@index'
    ],
    'about' => [
        'pattern' => '/about',
        'method' => 'GET',
        'action' => 'home@index',
        "middleware" => ["auth"],
    ],
    'contact' => [
        'pattern' => '/contact',
        'method' => 'GET'
    ]
];
