<?php

class CRM_EntityTemplates_Page_EntityTemplates extends CRM_Core_Page_Basic {

  /**
   * The action links that we need to display for the browse screen.
   *
   * @var array
   */
  static $_links = NULL;

  /**
   * Get BAO Name.
   *
   * @return string
   *   Classname of BAO.
   */
  public function getBAOName() {
    return 'CRM_EntityTemplates_BAO_EntityTemplates';
  }

  /**
   * Get action Links.
   *
   * @return array
   *   (reference) of action links
   */
  public function &links() {
    if (!(self::$_links)) {
      self::$_links = [
        CRM_Core_Action::UPDATE => [
          'name' => ts('Edit'),
          'url' => '%%url%%',
          'qs' => '%%query%%&templateId=%%id%%',
          'title' => ts('Edit template'),
        ],
        CRM_Core_Action::DELETE => [
          'name' => ts('Delete'),
          'url' => 'civicrm/entity/templates',
          'qs' => 'action=delete&id=%%id%%',
          'ref' => 'delete-entity-template',
          'title' => ts('Delete template'),
        ],
      ];
    }
    return self::$_links;
  }

  /**
   * Browse all Grant Budget.
   */
  public function browse() {

    //check permission
    if (!CRM_Core_Permission::check('administer CiviCRM')) {
      return CRM_Utils_System::permissionDenied();
    }
    $entityType = CRM_Utils_Request::retrieve('entityType', 'String');
    $entityTypes = CRM_EntityTemplates_BAO_EntityTemplates::getEntityTypes();
    if (empty($entityType)) {
      $entityType = key($entityTypes);
    }
    try {
      $optionValueName = civicrm_api3('OptionValue', 'getvalue', [
        'option_group_id' => "entity_template_for",
        'value' => $entityType,
        'return' => 'name',
      ]);
    }
    catch (CiviCRM_API3_Exception $e) {
      CRM_Core_Error::statusBounce(
        ts('Invalid Entity type.'),
        CRM_Utils_System::url('civicrm', "reset=1")
      );
    }
    list($url, $query) = explode('?', $optionValueName);
    $query .= "&entityTemplate={$entityType}";
    $entityTypeOptions = '';
    foreach ($entityTypes as $key => $value) {
      $extra = '';
      if ($key == $entityType) {
        $extra = 'selected="selected"';
      }
      $entityTypeOptions .= "<option value='{$key}' {$extra}>{$value}</option>";
    }
    $this->assign('entityTypeOptions', $entityTypeOptions);

    $results = civicrm_api3('EntityTemplates', 'get', [
      'entity_table' => $entityType,
      'return' => ['title', 'id'],
    ]);
    $rows = [];
    $action = array_sum(array_keys($this->links()));
    foreach ($results['values'] as $values) {
      $rows[] = [
        'id' => $values['id'],
        'title' => $values['title'],
        'links' => CRM_Core_Action::formLink(
          self::links(),
          $action,
          [
            'id' => $values['id'],
            'url' => $url,
            'query' => $query,
          ],
          ts('more'),
          FALSE,
          'entitytemplates.manage.action',
          'EntityTemplates',
          $values['id']
        ),
      ];
    }

    $this->assign('rows', $rows);
    $this->assign('url', $url);
    $this->assign('query', $query);
    $this->assign('entityType', $entityType);
  }

  /**
   * Get edit form name.
   *
   * @return string
   *   name of this page.
   */
  public function editName() {
    return ts('Entity Templates');
  }

  /**
   * Get name of edit form.
   *
   * @return string
   *   Classname of edit form.
   */
  public function editForm() {
    return 'CRM_EntityTemplates_Page_EntityTemplates';
  }

  /**
   * Get user context.
   *
   * @param null $mode
   *
   * @return string
   *   user context.
   */
  public function userContext($mode = NULL) {
    return 'civicrm/grant/annual/budgets';
  }

}
