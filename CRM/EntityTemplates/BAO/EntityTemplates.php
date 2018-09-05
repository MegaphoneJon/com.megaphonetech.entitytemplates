<?php

class CRM_EntityTemplates_BAO_EntityTemplates extends CRM_Core_DAO_EntityTemplates {

  /**
   * Build Entity option list.
   *
   */
  public static function getEntityTypes() {
    $result = civicrm_api3('OptionValue', 'get', [
      'return' => ["value"],
      'option_group_id' => "entity_template_for",
      'options' => ['limit' => 0],
    ]);
    return array_column($result['values'], 'value', 'value');
  }

  /**
   * Create Entity Template.
   *
   * @param array $params
   *
   * @throws Exception
   * @return CRM_EntityTemplates_BAO_EntityTemplates|CRM_Core_Error|null
   */
  public static function add($params) {

    if (empty($params['entity_table'])) {
      throw new CRM_Core_Exception(ts('Entity Table is mandatory.'));
    }
    try {
      $optionValueName = civicrm_api3('OptionValue', 'getvalue', [
        'option_group_id' => "entity_template_for",
        'value' => $params['entity_table'],
        'return' => 'name',
      ]);
    }
    catch (CiviCRM_API3_Exception $e) {
      throw new CRM_Core_Exception(ts('Invalid Entity Type.'));
    }

    if (empty($params['form_values'])) {
      return NULL;
    }
    $params['form_values'] = json_encode($params['form_values']);

    if (!empty($params['id'])) {
      CRM_Utils_Hook::pre('edit', 'EntityTemplates', $params['id'], $params);
    }
    else {
      CRM_Utils_Hook::pre('create', 'EntityTemplates', NULL, $params);
    }

    $entityTemplates = new CRM_EntityTemplates_BAO_EntityTemplates();
    $entityTemplates->copyValues($params);
    $entityTemplates->save();

    if (!empty($params['id'])) {
      CRM_Utils_Hook::post('edit', 'EntityTemplates', $entityTemplates->id, $entityTemplates);
    }
    else {
      CRM_Utils_Hook::post('create', 'EntityTemplates', $entityTemplates->id, $entityTemplates);
    }

    return $entityTemplates;
  }

  /**
   * Get Form values.
   *
   * @param int $templateId
   *
   * @return array
   */
  public static function getFormValues($templateId) {
    $formValues = civicrm_api3('EntityTemplates', 'getvalue', [
      'id' => $templateId,
      'return' => 'form_values',
    ]);
    return json_decode($formValues, TRUE);
  }

  /**
   * Get all entity template for entity type.
   *
   * @param string $entityType
   *
   * @return array
   */
  public static function getEntityTemplates($entityType) {
    $templates = civicrm_api3('EntityTemplates', 'get', [
      'return' => ['id', 'title'],
      'entity_table' => $entityType,
    ]);
    return array_column($templates['values'], 'title', 'id');
  }

  /**
   * Create Entity Template.
   *
   * @param string $formName
   * @param string $entityTemplate   *
   * @param int $entityTemplateId
   * @param string $contactType
   *
   * @return array|null
   */
  public static function getTemplateValues(
    $formName,
    $entityTemplate,
    $entityTemplateId,
    $contactType
  ) {
    try {
      $params = [
        'option_group_id' => "entity_template_for",
      ];
      if ($entityTemplate || $contactType) {
        $params['value'] = $entityTemplate ? $entityTemplate : $contactType;
      }
      else {
        $params['description'] = $formName;
      }
      $result = civicrm_api3('OptionValue', 'getsingle', $params);

      if ($formName == $result['description']) {
        return $result;
      }
    }
    catch (CiviCRM_API3_Exception $e) {
    }
    return NULL;
  }

}
