<?php
/**
 * Version
 * Handles the upgrading of the we play version
 */

defined('MOODLE_INTERNAL') || die(); //Internal file - Not accessible by browser

$plugin->component = 'block_weplay';  // Recommended since 2.0.2 (MDL-26035). Required since 3.0 (MDL-48494)
$plugin->version = 2019072007;  // YYYYMMDDHH (year, month, day, 24-hr time)
$plugin->requires = 2018050800; //Version of Moodle v3.5