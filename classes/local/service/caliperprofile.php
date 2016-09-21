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
 * This file contains a class definition for the Caliper Profile service
 *
 * @package    ltiservice_caliperprofile
 * @copyright  2016 SPV Software Products http://www.spvsoftwareproducts.com
 * @author     Stephen Vickers
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace ltiservice_caliperprofile\local\service;

defined('MOODLE_INTERNAL') || die();

/**
 * A service implementing Caliper Profile.
 *
 * @package    ltiservice_caliperprofile
 * @since      Moodle 3.1
 * @copyright  2016 SPV Software Products http://www.spvsoftwareproducts.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class caliperprofile extends \mod_lti\local\ltiservice\service_base {

    /**
     * Class constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->id = 'caliperprofile';
        $this->name = get_string('servicename', 'ltiservice_caliperprofile');

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    public function get_resources() {

        $this->resources = array();
        $this->resources[] = new \ltiservice_caliperprofile\local\resource\caliperprofileresource($this);

        return $this->resources;

    }

}
