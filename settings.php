<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Redirect the user to the appropriate submission related page
 *
 * @package   mod_codeactivity
 * @category  grade
 * @copyright 2014 Ryan Nutt http://www.nutt.net
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$settings->add(new admin_seting_configfile('mod_codeactivity/pathtojava',
        get_string('pathtojava', 'codeactivity'),
        get_string('pathtojava_help', 'codeactivity'),
        ''));
$settings->add(new admin_setting_configfile('mod_codeactivity/pathtojavac',
        get_string('pathtojavac', 'codeactivity'),
        get_string('pathtojavac_help', 'codeactivity'),
        ''));
$settings->add(new admin_setting_configfile('mod_codeactivity/pathtojunit',
        get_string('pathtojunit', 'codeactivity'),
        get_string('pathtojunit_help', 'codeactivity'),
        ''));
$settings->add(new admin_setting_configfile('mod_codeactivity/pathtohamcrest',
        get_string('pathtohamcrest', 'codeactivity'),
        get_string('pathtohamcrest_help', 'codeactivity'),
        ''));

$settings->add(new admin_setting_configfile('mod_codeactivity/pathtopy2',
        get_string('pathtopy2', 'codeactivity'),
        get_string('pathtopy2_help', 'codeactivity'),
        ''));
$settings->add(new admin_setting_configfile('mod_codeactivity/pathtopy3',
        get_string('pathtopy3', 'codeactivity'),
        get_string('pathtopy3_help', 'codeactivity'),
        '')); 

$settings->add(new admin_setting_configtext('mod_codeactivity/defaulttimeout',
        get_string('defaulttimeout', 'codeactivity'),
        get_string('defaulttimeout_help', 'codeactivity'),
        2,
        PARAM_INT));