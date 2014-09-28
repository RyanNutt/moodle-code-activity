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
        global $PAGE, $CFG; 
        $PAGE->requires->jquery();
        $PAGE->requires->jquery_plugin('ui');
        $PAGE->requires->jquery_plugin('ui-css');

        $PAGE->requires->js('/mod/codeactivity/js/codeactivity.js');
        $PAGE->requires->js('/mod/codeactivity/js/ace/ace.js'); 
        
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

        $this->testsSection(); 
        

        //-------------------------------------------------------------------------------
        // add standard elements, common to all modules
        $this->standard_coursemodule_elements();
        //-------------------------------------------------------------------------------
        // add standard buttons, common to all modules
        $this->add_action_buttons();
        
        $this->_form->addElement('html', '<script type="text/javascript">jQuery(document).ready(function() {codeActivity.initEdit(); codeActivity.ajaxURL = "' . $CFG->wwwroot . '/mod/codeactivity/ajax.php"; console.info(codeActivity);}); </script>'); 
    }
    
    /**
     * Output the timing section of the form
     * @param type $mform
     */
    private function timingSection() {
        $this->_form->addElement('header', 'timing', get_string('timing', 'codeactivity')); 
        
        $this->_form->addElement('date_time_selector', 'opendate', get_string('open_date', 'codeactivity'), self::$datefieldoptions);
        $this->_form->addHelpButton(
                'opendate',
                'open_date',
                'codeactivity');
        $this->_form->addElement('date_time_selector', 'duedate', get_string('due_date', 'codeactivity'), self::$datefieldoptions);
        $this->_form->addHelpButton(
                'duedate',
                'due_date',
                'codeactivity'); 
    }
    
    /**
     * Output the Files section of the form
     * @param type $mform
     */
    private function filesSection() {
        $this->_form->addElement('header', 'files', 'Files'); 

        
        $this->_form->addElement(
                'filemanager', 
                'files_student', 
                get_string('files_student', 'codeactivity'), 
                null,
                self::$fileoptions
                );
        $this->_form->addHelpButton(
                'files_student',
                'files_student',
                'codeactivity'); 
        
        
        $this->_form->addElement(
                'filemanager',
                'files_readonly',
                get_string('files_readonly', 'codeactivity'),
                null,
                self::$fileoptions
                );
        $this->_form->addHelpButton(
                'files_readonly',
                'files_readonly',
                'codeactivity');
        
        $this->_form->addElement(
                'filemanager',
                'files_extra',
                get_string('files_extra', 'codeactivity'),
                null,
                self::$fileoptions
                );
        $this->_form->addHelpButton(
                'files_extra',
                'files_extra',
                'codeactivity'); 
    }
    
    /**
     * Output the Tests section of the form
     * @param type $mform
     */
    private function testsSection() {
        $this->_form->addElement('header', 'tests', 'Tests'); 
        
        $this->_form->addElement('html', '<div id="ca-tests"><fieldset class="felement fitem"');
        $this->_form->addElement('html', 'Contents'); 
        $this->_form->addElement('html', '</fieldset></div>'); // #ca-tests
        
        $this->_form->addElement('html', '<div id="ca-add-test" style="display:none;">');
        //get_string('codeactivityname', 'codeactivity'), array('size'=>'64'));
        $this->_form->addElement('text',
                'testname',
                get_string('test_name', 'codeactivity'),
                array('size' => '64')
                );
        $this->_form->setType('testname', PARAM_RAW);
        $this->_form->addElement(
                'select', 
                'testtype', 
                get_string('test_type', 'codeactivity'), 
                array(
                    'unittest' => get_string('unittest', 'codeactivity'), 
                    'outputmatch' => get_string('outputmatch', 'codeactivity')
                    )
                ); 
        
        $this->_form->addElement('html', '<div id="ca-unittestcode" style="display:none;">'); 
        $this->_form->addElement(
                'textarea',
                'unittestcode',
                get_string('unittest_code', 'codeactivity')
                ); 
        $this->_form->addElement('html', '</div>'); 
        
        $this->_form->addElement('html', '<div id="ca-outputmatching" style="display:none;">');
        $this->_form->addElement(
                'select',
                'runfile',
                get_string('runfile', 'codeactivity'),
                array()); 
        
        $this->_form->addElement(
                'textarea',
                'expectedoutput',
                get_string('expected_output', 'codeactivity')); 

        $this->_form->addElement(
                'selectyesno',
                'convertnulls',
                get_string('convert_nulls', 'codeactivity')); 
        $this->_form->addElement(
                'selectyesno',
                'ignorewhitespace',
                get_string('ignore_whitespace', 'codeactivity')); 
        $this->_form->addElement('html', '</div>'); 
        
        $this->_form->addElement('html', '</div>'); // #ca-add-test
        
        $buttonarray=array();
        
        $buttonarray[] = $this->_form->createElement('button', 'add_test', 'Add Test');
        $buttonarray[] = $this->_form->createElement('button', 'add_save', 'Save');
        $buttonarray[] = $this->_form->createElement('button', 'add_cancel', 'Cancel');
        
        $this->_form->addGroup($buttonarray, 'add_buttons', '', array(''), false);
        
        $this->_form->addElement('hidden', 'ca_temp_code', uniqid()); 
        $this->_form->setType('ca_temp_code', PARAM_RAW); 
       
    }
    function data_preprocessing(&$default_values) {
        if ($this->current->instance) {
            // editing existing instance - copy existing files into draft area
            $draftitemid = file_get_submitted_draft_itemid('files_student');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_codeactivity', 'files_student', 0, array('subdirs'=>false));
            $default_values['files_student'] = $draftitemid;
            
            // Read only files
            $draftitemid = file_get_submitted_draft_itemid('files_readonly');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_codeactivity', 'files_readonly', 0, array('subdirs' => false));
            $default_values['files_readonly'] = $draftitemid;
            
            // Extra files
            $draftitemid = file_get_submitted_draft_itemid('files_extra');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_codeactivity', 'files_extra', 0, array('subdirs' => false));
            $default_values['files_extra'] = $draftitemid; 
        }
    }
    
}
