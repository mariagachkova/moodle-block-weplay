<?php
$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('global_configuration_title', 'block_weplay'),
    get_string('global_configuration_title_i', 'block_weplay')
));

$options = [
    0    => new lang_string('neverdeletelogs'),
    1000 => new lang_string('numdays', '', 1000),
    365  => new lang_string('numdays', '', 365),
    180  => new lang_string('numdays', '', 180),
    150  => new lang_string('numdays', '', 150),
    120  => new lang_string('numdays', '', 120),
    90   => new lang_string('numdays', '', 90),
    60   => new lang_string('numdays', '', 60),
    35   => new lang_string('numdays', '', 35),
    10   => new lang_string('numdays', '', 10),
    5    => new lang_string('numdays', '', 5),
    2    => new lang_string('numdays', '', 2)];
$settings->add(new admin_setting_configselect('weplay/loglifetime',
    new lang_string('loglifetime', 'core_admin'),
    new lang_string('configloglifetime', 'core_admin'), 60, $options));