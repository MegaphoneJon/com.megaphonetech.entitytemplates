<?php

class CRM_EntityTemplates_Utils {

  /**
   * Build all the data structures needed to build the form.
   *
   * @param string $formName
   * @param object $form
   */
  public static function preProcess($formName, &$form) {
    if (!($form->getVar('_action') & CRM_Core_Action::ADD)
    ) {
      return;
    }
    $form->_entityTemplate = CRM_Utils_Request::retrieve('entityTemplate', 'String', $form);
    $form->_entityTemplateId = CRM_Utils_Request::retrieve('templateId', 'Integer', $form);
    $contactType = NULL;
    if ('CRM_Contact_Form_Contact' == $formName) {
      $contactType = $form->getVar('_contactType');
    }
    $form->_entityTemplateValues = CRM_EntityTemplates_BAO_EntityTemplates::getTemplateValues(
      $formName,
      $form->_entityTemplate,
      $form->_entityTemplateId,
      $contactType
    );
  }

  /**
   * Build the form object.
   *
   * @param string $formName
   * @param object $form
   */
  public static function buildForm($formName, &$form) {
    if (!empty($form->_entityTemplateValues)) {
      if ($form->_entityTemplate) {
        unset($form->_required);
        $form->add('hidden', 'entity_template', $form->_entityTemplate);
        if ($form->_entityTemplateId) {
          $form->add('hidden', 'entity_template_id', $form->_entityTemplateId);
        }
        $form->add('text', 'entity_template_title', ts('Template Title'), [], TRUE);
      }
      else {
        $entities = CRM_EntityTemplates_BAO_EntityTemplates::getEntityTemplates($form->_entityTemplateValues['value']);
        if (!empty($entities)) {
          $form->add('select', 'entity_template_id', ts('Templates'), $entities, FALSE, ['placeholder' => ts('- select -'), 'class' => 'crm-select2']);

          list($url, $query) = explode('?', $form->_entityTemplateValues['name']);
          $queryString = $form->get('queryString');
          if (empty($queryString)) {
            if (!empty($_SERVER['REDIRECT_QUERY_STRING'])) {
              $queryString = $_SERVER['REDIRECT_QUERY_STRING'];
            }
            else {
              $queryString = $query;
            }
          }
          parse_str($queryString, $queryString);
          if (isset($queryString['templateId'])) {
            unset($queryString['templateId']);
          }
          if (isset($queryString['snippet'])) {
            unset($queryString['snippet']);
          }
          $queryString = http_build_query($queryString);
          $form->set('queryString', $queryString);
          $url = CRM_Utils_System::url($url, $queryString, FALSE, NULL, FALSE);
          $form->assign('redirectUrl', $url);
        }
      }
      if ($form->_entityTemplateId) {
        $formValues = CRM_EntityTemplates_BAO_EntityTemplates::getFormValues($form->_entityTemplateId);
        $formValues['entity_template_id'] = $form->_entityTemplateId;
        $form->setDefaults($formValues);
      }
      CRM_Core_Region::instance('page-body')->add([
        'template' => 'CRM/EntityTemplates/EntityTemplate.tpl',
      ]);
    }
  }

  /**
   * Add entity template.
   *
   * @param string $objectName
   * @param array $params
   */
  public static function addTemplate($objectName, $params) {
    if (CRM_Utils_Array::value('entity_template', $params) == $objectName) {
      $id = NULL;
      if (!empty($params['entity_template_id'])) {
        $id = $params['entity_template_id'];
      }

      // unset entity template fields
      unset(
        $params['is_entity_template'],
        $params['entity_template_id'],
        $params['qfKey'],
        $params['entryURL']
      );

      $entityParams = [
        'entity_table' => $objectName,
        'title' => CRM_Utils_Array::value('entity_template_title', $params, rand()),
        'form_values' => $params,
      ];
      if ($id) {
        $entityParams['id'] = $id;
      }

      civicrm_api3('EntityTemplates', 'create', $entityParams);

      // print message
      CRM_Core_Session::setStatus(ts('Entity template saved successfully'), ts('Entity template'), 'success');
      // redirect to list page
      $url = CRM_Utils_System::url('civicrm/entity/templates', "reset=1&entityType={$objectName}");
      CRM_Utils_System::redirect($url);
    }
  }

}
