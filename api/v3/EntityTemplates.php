<?php
/**
 * This api exposes CiviCRM EntityTemplates.
 *
 * @package CiviCRM_APIv3
 */

/**
 * Save a EntityTemplates.
 *
 * @param array $params
 *
 * @return array
 */
function civicrm_api3_entity_templates_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params, 'EntityTemplates');
}

/**
 * Get a EntityTemplates.
 *
 * @param array $params
 *
 * @return array
 *   Array of retrieved EntityTemplates property values.
 */
function civicrm_api3_entity_templates_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params, TRUE, 'EntityTemplates');
}

/**
 * Delete a EntityTemplates.
 *
 * @param array $params
 *
 * @return array
 *   Array of deleted values.
 */
function civicrm_api3_entity_templates_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}
