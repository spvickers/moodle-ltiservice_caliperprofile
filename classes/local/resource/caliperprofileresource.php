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
 * This file contains a class definition for the Caliper Profile resource
 *
 * @package    ltiservice_caliperprofile
 * @copyright  2016 SPV Software Products http://www.spvsoftwareproducts.com
 * @author     Stephen Vickers
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


namespace ltiservice_caliperprofile\local\resource;

use \mod_lti\local\ltiservice\service_base;
use ltiservice_caliperprofile\local\service\caliperprofile;

defined('MOODLE_INTERNAL') || die();

/**
 * A resource implementing Caliper Profile.
 *
 * @package    ltiservice_caliperprofile
 * @since      Moodle 3.1
 * @copyright  2016 SPV Software Products http://www.spvsoftwareproducts.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class caliperprofileresource extends \mod_lti\local\ltiservice\resource_base {

    /**
     * Class constructor.
     *
     * @param ltiservice_caliperprofile\local\service\caliperprofile $service Service instance
     */
    public function __construct($service) {

        parent::__construct($service);
        $this->id = 'CaliperProfile';
        $this->template = '/caliper/{tool_proxy_id}/profile';
        $this->variables[] = 'Caliper.profile.url';
        $this->variables[] = 'Caliper.sessionId';
        $this->formats[] = 'application/vnd.ims.lti.v1.caliperprofile+json';
        $this->methods[] = 'GET';

    }

    /**
     * Execute the request for this resource.
     *
     * @param mod_lti\local\ltiservice\response $response  Response object for this request.
     */
    public function execute($response) {

        $params = $this->parse_template();
        $tpid = $params['tool_proxy_id'];
        $ok = !empty($tpid) && $this->check_tool_proxy($tpid, $response->get_request_data());
        if (!$ok) {
            $response->set_code(401);
        } else {
            $profile = new \stdClass();
            $profile->{'@context'} = 'http://purl.imsglobal.org/ctx/lti/v1/CaliperProfile';
            $profile->type = 'CaliperProfile';
            $profile->id = $this->get_endpoint();
            $profile->eventStoreUrl = get_config('logstore_caliper', 'endpoint');
            $profile->apiKey = get_config('logstore_caliper', 'apikey');
            $response->set_content_type($this->formats[0]);
            $response->set_body(json_encode($profile, JSON_PRETTY_PRINT));
        }

    }

    /**
     * Parse a value for custom parameter substitution variables.
     *
     * @param string $value String to be parsed
     *
     * @return string
     */
    public function parse_value($value) {

        $value = str_replace('$Caliper.profile.url', parent::get_endpoint(), $value);
        $value = str_replace('$Caliper.sessionId', session_id(), $value);

        return $value;

    }

}
