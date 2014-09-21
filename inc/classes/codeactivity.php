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
    
}

