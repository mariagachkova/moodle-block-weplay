<?php
$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('global_configuration_title', 'block_weplay'),
    get_string('global_configuration_title_i', 'block_weplay')
));

$settings->add(new admin_setting_configcheckbox(
    'weplay/use_crud',
    get_string('global_configuration_label', 'block_weplay'),
    get_string('global_configuration_description', 'block_weplay'),
    1
));