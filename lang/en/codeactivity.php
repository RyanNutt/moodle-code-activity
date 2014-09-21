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
 * English strings for codeactivity
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_codeactivity
 * @copyright  2014 Ryan Nutt http://www.nutt.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'Code Activity';
$string['modulenameplural'] = 'Code Activities';
$string['modulename_help'] = 'Use the codeactivity module for... | The codeactivity module allows...';
$string['codeactivityfieldset'] = 'Custom example fieldset';
$string['codeactivityname'] = 'Code Activity Name';
$string['codeactivityname_help'] = 'This is the content of the help tooltip associated with the codeactivityname field. Markdown syntax is supported.';
$string['codeactivity'] = 'Code Activity';
$string['pluginadministration'] = 'Code Activity Admin';
$string['pluginname'] = 'Code Activity';

// Strings for the settings page
$string['pathtojava']           = 'Path to Java';
$string['pathtojava_help']      = 'Server path to the Java executable';
$string['pathtojavac']          = 'Path to JavaC';
$string['pathtojavac_help']     = 'Server path to the Java compiler'; 
$string['pathtopy2']            = 'Path to Python 2'; 
$string['pathtopy2_help']       = 'Server path to the Python 2 interpreter'; 
$string['pathtopy3']            = 'Path to Python 3'; 
$string['pathtopy3_help']       = 'Server path to the Python 3 interpreter';
$string['pathtohamcrest']       = 'Path to Hamcrest.jar'; 
$string['pathtohamcrest_help']  = 'Server path to the hamcrest.jar file. This file is needed by JUnit for running tests.';
$string['pathtojunit']          = 'Path to JUnit.jar'; 
$string['pathtojunit_help']     = 'Server path to the junit.jar file. This file is needed to run unit tests on Java files.'; 
$string['defaulttimeout']       = 'Default timeout';
$string['defaulttimeout_help']  = 'Default number of seconds before a test is considered a failure. This can be overwritten on individual tests and also in JUnit test files.'; 
