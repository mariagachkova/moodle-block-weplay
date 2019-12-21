<?php

$observers = [
    [
        'eventname'   => '*',
        'callback'    => 'block_wp\\local\\observer\\observer::catch_all',
//        'includefile' => null,
        'internal'    => false,
//        'priority'    => 9999,
    ]
];