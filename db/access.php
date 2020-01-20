<?php
/**
 * Capabilities
 * Control the use of individual blocks
 */

$capabilities = [

    'block/weplay:myaddinstance' => [
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => [
            'user' => CAP_ALLOW
        ],

        'clonepermissionsfrom' => 'moodle/my:manageblocks'
    ],

    'block/weplay:addinstance' => [
        'riskbitmask' => RISK_SPAM | RISK_XSS,

        'captype' => 'write',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => [
            'editingteacher' => CAP_ALLOW,
            'manager' => CAP_ALLOW
        ],

        'clonepermissionsfrom' => 'moodle/site:manageblocks'
    ],

    // Whether or not a user can earn plugin point.
    'block/weplay:earnpoint' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_BLOCK,
        'archetypes' => array(
            'student' => CAP_ALLOW
        ),
    ),
    'block/weplay:view' => [
        'captype' => 'read',
        'contextlevel' => CONTEXT_COURSE,
        'archetypes' => [
            'user' => CAP_ALLOW
        ],
    ],
];