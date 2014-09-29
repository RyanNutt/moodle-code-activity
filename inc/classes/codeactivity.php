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

defined('MOODLE_INTERNAL') || die();

/**
 * Class of support methods.
 * 
 * Done as mostly static methods to act as a pseudo namespace, similar to 
 * how WordPress suggest their plugins are written. 
 */
class codeactivity {
    
    /**
     * Returns a keyed array of the languages available, or an empty
     * array if there aren't any.
     */
    public static function getLanguages() {
        $out = array();
        if (self::javaAvailable()) {
            $out['java'] = 'Java'; 
        }
        if (self::py2Available()) {
            $out['py2'] = 'Python 2';
        }
        if (self::py3Available()) {
            $out['py3'] = 'Python 3'; 
        }
        return $out;
    }
    
    /**
     * Check if both java and javac are available and executable
     */
    public static function javaAvailable() {
        $config = get_config('mod_codeactivity');
        if (empty($config->pathtojava) || !is_executable($config->pathtojava)) {
            return false;
        }
        if (empty($config->pathtojavac) || !is_executable($config->pathtojavac)) {
            return false; 
        }
        return true; 
    }
    
    /** 
     * Check if the Python2 interpreter is available and executable
     */
    public static function py2Available() {
        $config = get_config('mod_codeactivity');
        if (!empty($config->pathtopy2) && is_executable($config->pathtopy2)) {
            return true; 
        } 
        return false; 
    }
    
    /**
     * Check if the Python3 interpreter is available and executable
     */
    public static function py3Available() {
        $config = get_config('mod_codeactivity');
        if (!empty($config->pathtopy3) && is_executable($config->pathtopy3)) {
            return true; 
        }
        return false; 
    }
    
    public static function ajaxListFiles() {
        $draftIDs = explode(',', $_POST['draftIDs']);
        $files = array(); 
        foreach ($draftIDs as $id) {
            $data = repository::prepare_listing(file_get_drafarea_files($id, '/'));
            if (!empty($data->list)) {
                foreach ($data->list as $f) {
                    $files[] = $f->filename;
                }
            } 
        }

        $out = array(
            'draftIDs' => $draftIDs,
            'files' => $files
        );

        header('Content-type: application/json');
        echo json_encode($out);
        die(); 
    }
    
    /**
     * Callback to add a new test to a specific activity. Returns back JSON
     * that gives the calling script information about the addition, or failure
     * of it. 
     */
    public static function ajaxAddTest() {
        $out = array();
        $out['status'] = true;
        $out['action'] = 'addTest'; 
        $out['POST'] = $_POST;
        
        $record = new stdClass();
        $record->convert_nulls = ($_POST['convert_nulls']) ? 1 : 0;
        $record->ignore_whitespace = $_POST['ignore_whitespace'] ? 1 : 0;
        $record->expected_output = $_POST['expected_output'];
        $record->run_file = $_POST['run_file'];
        $record->test_name = $_POST['test_name'];
        $record->test_type = $_POST['test_type'];
        $record->unittest_code = $_POST['unittest_code'];
        $record->activity_id = 0;
        $record->temp_id = $_POST['temp_id'];
        
        $insertID = self::saveActivity($record); 
        
        $out['id'] = $insertID;
        $out['html'] = self::testHTML($insertID);
        
        header('Content-type: application/json');
        echo json_encode($out);
        die(); 
    }
    
    /**
     * Returns the HTML to display a row for a specific test ID.
     * @param type $testID
     */
    public static function testHTML($testID) {
        global $DB, $CFG;
        $result = $DB->get_record('codeactivity_tests', array('id' => $testID));
        if (!$result) {
            return 'Error retrieving test ID '.$testID;
        }
        else {
            //print_r($result); 
            $html = '<div class="test-wrapper">
                    <img class="click" src="' . $CFG->wwwroot . '/mod/codeactivity/pix/trash-32.png">
                    <img class="click" src="' . $CFG->wwwroot . '/mod/codeactivity/pix/pencil-32.png">
                    <img src="' . $CFG->wwwroot . '/mod/codeactivity/pix/'.(($result->test_type=='unittest') ? 'code-32.png' : 'print-32.png') . '">
                        <div class="name">' . $result->test_name . '</div>
                </div>';
            return $html;
        }
    }
    
    /**
     * Save an activity to the database, or update it if it already exists
     * 
     * @param stdClass $activity
     */
    public static function saveActivity($activity) {
        global $DB; 
        if (!empty($activity->id)) {
            return $DB->update_record('codeactivity_tests', $activity); 
        }
        else {
            return $DB->insert_record('codeactivity_tests', $activity); 
        }
    }
    
}

