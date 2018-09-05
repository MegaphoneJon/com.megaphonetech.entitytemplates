<?php

require_once 'entitytemplates.civix.php';
use CRM_Entitytemplates_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function entitytemplates_civicrm_config(&$config) {
  _entitytemplates_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function entitytemplates_civicrm_xmlMenu(&$files) {
  _entitytemplates_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function entitytemplates_civicrm_install() {
  _entitytemplates_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function entitytemplates_civicrm_postInstall() {
  _entitytemplates_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function entitytemplates_civicrm_uninstall() {
  _entitytemplates_civix_civicrm_uninstall();
  CRM_Core_DAO::executeQuery('
    DROP TABLE IF EXISTS civicrm_entity_templates;
  ');
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function entitytemplates_civicrm_enable() {
  _entitytemplates_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function entitytemplates_civicrm_disable() {
  _entitytemplates_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function entitytemplates_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _entitytemplates_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function entitytemplates_civicrm_managed(&$entities) {
  _entitytemplates_civix_civicrm_managed($entities);
  $entities[] = [
    'module' => 'com.megaphonetech.entitytemplates',
    'name' => 'entity_template_for',
    'entity' => 'OptionGroup',
    'params' => [
      'name' => 'entity_template_for',
      'title' => ts('Entity Template for'),
      'data_type' => 'String',
      'is_reserved' => 1,
      'is_active' => 1,
      'is_locked' => 0,
      'version' => 3,
    ],
  ];
  foreach ([
    'Individual' => ['CRM_Contact_Form_Contact', 'civicrm/contact/add?reset=1&ct=Individual'],
    'Organization' => ['CRM_Contact_Form_Contact', 'civicrm/contact/add?reset=1&ct=Organization'],
    'Contribution' => ['CRM_Contribute_Form_Contribution', 'civicrm/contribute/add?reset=1&action=add&context=standalone'],
  ] as $entityType => $formClassName) {
    $entities[] = [
      'module' => 'com.megaphonetech.entitytemplates',
      'name' => $entityType,
      'entity' => 'OptionValue',
      'params' => [
        'version' => 3,
        'option_group_id' => 'entity_template_for',
        'label' => ts("{$entityType}"),
        'value' => $entityType,
        'name' => $formClassName[1],
        'description' => $formClassName[0],
        'is_default' => '0',
        'weight' => '1',
        'is_optgroup' => '0',
        'is_reserved' => '0',
        'is_active' => '1'
      ],
    ];
  }
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function entitytemplates_civicrm_caseTypes(&$caseTypes) {
  _entitytemplates_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function entitytemplates_civicrm_angularModules(&$angularModules) {
  _entitytemplates_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function entitytemplates_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _entitytemplates_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_entityTypes
 */
function entitytemplates_civicrm_entityTypes(&$entityTypes) {
  _entitytemplates_civix_civicrm_entityTypes($entityTypes);
  $entityTypes[] = [
    'name'  => 'EntityTemplates',
    'class' => 'CRM_EntityTemplates_BAO_EntityTemplates',
    'table' => 'civicrm_entity_templates',
  ];
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
 */
function entitytemplates_civicrm_navigationMenu(&$menu) {
  _entitytemplates_civix_insert_navigation_menu($menu, 'Administer/Customize Data and Screens', [
    'label' => ts('Entity Templates', ['domain' => 'com.megaphonetech.entitytemplates']),
    'name' => 'entity_templates',
    'url' => CRM_Utils_System::url('civicrm/entity/templates', 'reset=1&action=browse', TRUE),
    'active' => 1,
    'permission_operator' => 'AND',
    'permission' => 'administer CiviCRM',
  ]);
  _entitytemplates_civix_navigationMenu($menu);
}

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
 */
function entitytemplates_civicrm_preProcess($formName, &$form) {
  CRM_EntityTemplates_Utils::preProcess($formName, $form);
}

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 *
 */
function entitytemplates_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Admin_Form_Options' && $form->getVar('_gName') == 'entity_template_for') {
    $form->add(
      'text',
      'name',
      ts('Url'),
      CRM_Core_DAO::getAttribute('CRM_Core_DAO_OptionValue', 'name')
    );
  }
  CRM_EntityTemplates_Utils::buildForm($formName, $form);
}

/**
 * Implements hook_civicrm_pre().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_pre
 *
 */
function entitytemplates_civicrm_pre($op, $objectName, $id, &$params) {
  if ($op == 'create') {
    CRM_EntityTemplates_Utils::addTemplate($objectName, $params);
  }
}

/**
 * Implements hook_civicrm_validateForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_validateForm
 *
 */
function entitytemplates_civicrm_validateForm($formName, &$fields, &$files, &$form, &$errors) {
  if (property_exists($form, '_entityTemplate') && $form->_entityTemplate) {
    if (!empty($fields['entity_template_title'])) {
      $params = [
        'title' => $fields['entity_template_title'],
        'entity_table' => $form->_entityTemplate,
      ];
      if ($form->_entityTemplateId) {
        $params['id'] = ['NOT IN' => [$form->_entityTemplateId]];
      }
      $count = civicrm_api3('EntityTemplates', 'getcount', $params);
      if ($count) {
        $errors['entity_template_title'] = ts('Title already exists.');
      }
    }
    if ($formName == 'CRM_Contact_Form_Contact') {
      $contactType = [
        ts('First Name and Last Name OR an email OR an OpenID in the Primary Location should be set.'),
        ts('Organization Name should be set.'),
        ts('Household Name should be set.'),
      ];
      $form->_errors = array_diff($form->_errors, $contactType);
    }
  }
}
