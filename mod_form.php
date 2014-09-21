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

require_once($CFG->dirroot.'/course/moodleform_mod.php');
require_once(__DIR__.'/inc/classes/codeactivity.php'); 

/**
 * Module instance settings form
 */
class mod_codeactivity_mod_form extends moodleform_mod {

    private static $datefieldoptions = array(
        'optional' => true,     // sets up the "Enable" checkbox
        'step' => 5);           // number of minutes in dropdown
    private static $fileoptions = array(
        'subdirs' => 0, 
        'maxbytes' => 0, 
        'maxfiles' => 50,
        'accepted_types' => '*' 
        );
    /**
     * Defines forms elements
     */
    public function definition() {

        $mform = $this->_form;

        /* Check to see if there are languages set, and if not display
         * a message.  The $languages variable is going to be used later
         * as well when the select box for languages is displayed. 
         */
        $languages = codeactivity::getLanguages();
        if (empty($languages)) {
            $mform->addElement('html', '<p class="ca-error">'.get_string('err_nolanguages', 'codeactivity').'</p>'); 
        }
        
        
        //-------------------------------------------------------------------------------
        // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));

        
        // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('codeactivityname', 'codeactivity'), array('size'=>'64'));
        if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
        $mform->addHelpButton('name', 'codeactivityname', 'codeactivity');
        
        // Adding the standard "intro" and "introformat" fields
        $this->add_intro_editor();

        // Language dropdown
        $mform->addElement('select', 'language', get_string('language', 'codeactivity'), $languages); 
        $mform->addHelpButton(
                'language',
                'language',
                'codeactivity'); 
        
        $this->timingSection($mform);
        
        $this->filesSection($mform);

        $this->testsSection($mform); 
        

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
    }
    
    /**
     * Output the timing section of the form
     * @param type $mform
     */
    private function timingSection($mform) {
        $mform->addElement('header', 'timing', get_string('timing', 'codeactivity')); 
        
        $mform->addElement('date_time_selector', 'opendate', get_string('open_date', 'codeactivity'), self::$datefieldoptions);
        $mform->addHelpButton(
                'opendate',
                'open_date',
                'codeactivity');
        $mform->addElement('date_time_selector', 'duedate', get_string('due_date', 'codeactivity'), self::$datefieldoptions);
        $mform->addHelpButton(
                'duedate',
                'due_date',
                'codeactivity'); 
    }
    
    /**
     * Output the Files section of the form
     * @param type $mform
     */
    private function filesSection($mform) {
        $mform->addElement('header', 'files', 'Files'); 
        
        $mform->addElement(
                'filemanager', 
                'files_student', 
                get_string('files_student', 'codeactivity'), 
                null,
                self::$fileoptions
                );
        $mform->addHelpButton(
                'files_student',
                'files_student',
                'codeactivity'); 
        
        $mform->addElement(
                'filemanager',
                'files_readonly',
                get_string('files_readonly', 'codeactivity'),
                null,
                self::$fileoptions
                );
        $mform->addHelpButton(
                'files_readonly',
                'files_readonly',
                'codeactivity');
        
        $mform->addElement(
                'filemanager',
                'files_extra',
                get_string('files_extra', 'codeactivity'),
                null,
                self::$fileoptions
                );
        $mform->addHelpButton(
                'files_extra',
                'files_extra',
                'codeactivity'); 
    }
    
    /**
     * Output the Tests section of the form
     * @param type $mform
     */
    private function testsSection($mform) {
        $mform->addElement('header', 'tests', 'Tests'); 
    }
}
