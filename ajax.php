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
 * The main codeactivity configuration form
 *
 * It uses the standard core Moodle formslib. For more info about them, please
 * visit: http://docs.moodle.org/en/Development:lib/formslib.php
 *
 * @package    mod_codeactivity
 * @copyright  2014 Ryan Nutt http://www.nutt.net
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
if (!defined('AJAX_SCRIPT')) {
    define('AJAX_SCRIPT', true);
}

require_once(dirname(__FILE__).'/../../config.php');
require_once($CFG->dirroot.'/repository/lib.php');
require_once(dirname(__FILE__).'/inc/classes/codeactivity.php'); 

// For unit tests to work.
global $CFG, $PAGE;

require_login(); 
  

if ($_POST['action'] == 'listFiles') {
    codeactivity::ajaxListFiles(); 
}
else if ($_POST['action'] == 'addTest') {
    codeactivity::ajaxAddTest();
}
else if ($_POST['action'] == 'deleteTest') {
    codeactivity::ajaxDeleteTest();
}
else {
    die('Invalid action parameter: ' . $_POST['action']);
}