<?php

$observers = [
    [
        'eventname'   => '*',
        'callback'    => 'block_weplay\\local\\observer\\observer::catch_all',
        'internal'    => false,
    ],
    [
        'eventname' => '\\core\\event\\course_deleted',
        'callback' => 'block_weplay\\local\\observer\\observer::course_deleted'
    ]
];