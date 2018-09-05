<div class="crm-content-block crm-block">
  <label>{ts}Entity Type: {/ts}</label>
  <select name="entityType" type="text" id="entityType" class="crm-form-select required crm-select2 twelve">
    {$entityTypeOptions}
  </select>
  </br></br>
  <table cellpadding="0" cellspacing="0" border="0" class="row-highlight">
    <thead class="sticky">
      <th>{ts}Title{/ts}</th>
      <th></th>
    </thead>
    {if $rows}
      {foreach from=$rows item=row}
        <tr id="EntityTemplates-{$row.id}" class="crm-entity {cycle values="odd-row,even-row"}">
          <td class='EntityTemplates-title'>{$row.title}</td>
          <td class='EntityTemplates-links'>{$row.links}</td>
        </tr>
      {/foreach}
    {else}
      <tr>
        <td style='text-align: center;' colspan="2">{ts}None found.{/ts}</td>
      </tr>
    {/if}
  </table>
  {crmButton p=$url q="`$query`" class="cancel" icon="times"}{ts}Add Template{/ts}{/crmButton}
  {crmButton p="civicrm" q="reset=1" class="cancel" icon="times"}{ts}Done{/ts}{/crmButton}
</div>

{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $('#entityType').change(loadPage);
    function loadPage() {
      window.location.href = CRM.url('civicrm/entity/templates', {
        reset: '1',
        entityType: $('#entityType').val()
      });
    }
    $('a.delete-entity-template').click(deleteEntity);
    function deleteEntity() {
      var row = $(this).closest('.crm-entity');
      var entityId = row.data('id') || row[0].id.split('-')[1];
      CRM.confirm({
        message: ts('Are you sure you want to delete this template?'),
        title: ts('Delete Template'),
        options: {{/literal}yes: '{ts escape="js"}Delete{/ts}', no: '{ts escape="js"}Cancel{/ts}'{literal}},
        width: 300,
        height: 'auto'
      })
      .on('crmConfirm:yes', function() {
        CRM.api3('EntityTemplates', 'delete', {id: entityId}, true).done(loadPage);
      });
      return false;
    }
  });
</script>
{/literal}
