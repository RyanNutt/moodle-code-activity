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

$string['codeactivity']             = 'Code Activity';
$string['codeactivityfieldset']     = 'Custom example fieldset';
$string['codeactivityname']         = 'Code Activity Name';
$string['codeactivityname_help']    = 'This is the content of the help tooltip associated with the codeactivityname field. Markdown syntax is supported.';
$string['convert_nulls']            = 'Convert nulls to spaces';
$string['defaulttimeout']           = 'Default timeout';
$string['defaulttimeout_help']      = 'Default number of seconds before a test is considered a failure. This can be overwritten on individual tests and also in JUnit test files.'; 
$string['delete_test']              = 'Delete this test';
$string['delete_this_test']         = 'Delete this test';
$string['due_date']                 = 'Due Date';
$string['due_date_help']            = 'The date that this assignment is due.<br><br>Code activities can still be submitted after this date, but they will be flagged as late in the activity results page. It is up to you to decide what to do with late submissions.';
$string['edit_test']                = 'Edit this test';
$string['edit_this_test']           = 'Edit this test';
$string['err_nolanguages']          = 'There are currently no languages set. You will need to <a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingcodeactivity">set at least one language</a> before using any activity created by this plugin.'; 
$string['expected_output']          = 'Expected Output';
$string['files_extra']              = 'Extra Files';
$string['files_extra_help']         = 'Extra files are those that are copied to the working folder, but not directly visable to your students. <br><br>These will normally be files like data files that you may want your students to read with their code, but not be able to directly view. Or, you could use this field to include additional files like .JAR files you need for your students\' or your test code to run.';
$string['files_readonly']           = 'Read Only Files';
$string['files_readonly_help']      = 'Read only files are viewable by your students in the assignment, but cannot be edited. Typically you will use these for example data files or sample output.';
$string['files_student']            = 'Student Files'; 
$string['files_student_help']       = 'Student files are those that your students will be directly editing as part of the assignment.';
$string['ignore_whitespace']        = 'Ignore trailing white space'; 
$string['js_empty_name']            = 'Please enter a name for this test'; 
$string['js_empty_test_code']       = 'Please enter unit test code for this test.'; 
$string['js_error_add']             = 'Unable to add this test. More information may be available in the console.';
$string['language']                 = 'Language'; 
$string['language_help']            = 'The coding language used in this activity.<br><br>The list of languages is based on the settings for this plugin.<br><br>If this list is empty then no languages are set correctly on the settings page for this plugin.';
$string['modulename']               = 'Code Activity';
$string['modulename_help']          = 'Use the codeactivity module for... | The codeactivity module allows...';
$string['modulenameplural']         = 'Code Activities';
$string['open_date']                = 'Open Date'; 
$string['open_date_help']           = 'The date that students can first open and view the activity'; 
$string['outputmatch']              = 'Output Matching'; 
$string['pathtohamcrest']           = 'Path to Hamcrest.jar'; 
$string['pathtohamcrest_help']      = 'Server path to the hamcrest.jar file. This file is needed by JUnit for running tests.';
$string['pathtojava']               = 'Path to Java';
$string['pathtojava_help']          = 'Server path to the Java executable';
$string['pathtojavac']              = 'Path to JavaC';
$string['pathtojavac_help']         = 'Server path to the Java compiler'; 
$string['pathtojunit']              = 'Path to JUnit.jar'; 
$string['pathtojunit_help']         = 'Server path to the junit.jar file. This file is needed to run unit tests on Java files.'; 
$string['pathtopy2']                = 'Path to Python 2'; 
$string['pathtopy2_help']           = 'Server path to the Python 2 interpreter'; 
$string['pathtopy3']                = 'Path to Python 3'; 
$string['pathtopy3_help']           = 'Server path to the Python 3 interpreter';
$string['pluginadministration']     = 'Code Activity Admin';
$string['pluginname']               = 'Code Activity';
$string['runfile']                  = 'File to run'; 
$string['test_name']                = 'Test Name'; 
$string['test_type']                = 'Test Type';
$string['timing']                   = 'Timing'; 
$string['type_output']              = 'Output matching test'; 
$string['type_unittest']            = 'Unit test';
$string['unittest']                 = 'Unit Test';
$string['unittest_code']            = 'Unit Test Code'; 
$string['js_error_delete']          = 'There was an unexpected error trying to delete this test. There may be more information available in the console.' ;
$string['js_error_forbidden']       = 'The server returned a "forbidden" error to the last request. This is normally caused by an incorrect capability setting.'; 
        