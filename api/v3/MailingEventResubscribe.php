<?php
// $Id$

/*
 +--------------------------------------------------------------------+
 | CiviCRM version 4.3                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2013                                |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the GNU Affero General Public License           |
 | Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the GNU Affero General Public License for more details.        |
 |                                                                    |
 | You should have received a copy of the GNU Affero General Public   |
 | License and the CiviCRM Licensing Exception along                  |
 | with this program; if not, contact CiviCRM LLC                     |
 | at info[AT]civicrm[DOT]org. If you have questions about the        |
 | GNU Affero General Public License or the licensing of CiviCRM,     |
 | see the CiviCRM license FAQ at http://civicrm.org/licensing        |
 +--------------------------------------------------------------------+
*/

/**
 *
 * APIv3 functions for registering/processing mailing group events.
 *
 * @package CiviCRM_APIv3
 * @subpackage API_MailerGroup
 * @copyright CiviCRM LLC (c) 2004-2013
 * $Id$
 *
 */

/**
 * Subscribe from mailing group
 *
 * @param array $params  Associative array of property
 *                       name/value pairs to insert in new 'survey'
 *
 * @return array api result array
 * {@getfields mailing_event_subscribe_create}
 * @access public
 */
function civicrm_api3_mailing_event_resubscribe_create($params) {

  $groups = CRM_Mailing_Event_BAO_Resubscribe::resub_to_mailing(
    $params['job_id'],
    $params['event_queue_id'],
    $params['hash']
  );

  if (count($groups)) {
    CRM_Mailing_Event_BAO_Resubscribe::send_resub_response(
      $params['event_queue_id'],
      $groups, FALSE,
      $params['job_id']
    );
    return civicrm_api3_create_success($params);
  }
  return civicrm_api3_create_error('Queue event could not be found');
}
/*
 * Adjust Metadata for Create action
 * 
 * The metadata is used for setting defaults, documentation & validation
 * @param array $params array or parameters determined by getfields
 */
function _civicrm_api3_mailing_event_resubscribe_create_spec(&$params) {
  $params['event_queue_id']['api.required'] = 1;
  $params['job_id']['api.required'] = 1;
  $params['hash']['api.required'] = 1;
}
