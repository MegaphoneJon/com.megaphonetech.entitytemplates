{if $form.entity_template_title}
  <table class='entity_template_title form-layout-compressed'>
    <tr>
      <td class='label'>{$form.entity_template_title.label}</td>
      <td>{$form.entity_template_title.html}</td>
    </tr>
  </table>
{else}
  <table class='entity_template_id form-layout-compressed'>
    <tr>
      <td class='label'>{$form.entity_template_id.label}</td>
      <td>{$form.entity_template_id.html}</td>
    </tr>
  </table>
{/if}
{literal}
<script type="text/javascript">
  CRM.$(function($) {
    $($('table.entity_template_title, table.entity_template_id')).insertAfter('div.crm-submit-buttons:first');
    $('#entity_template_id').change(function() {
      window.location.href  = '{/literal}{$redirectUrl}{literal}&templateId=' + $(this).val();
    });
    window.onbeforeunload = function() {};
  });
</script>
{/literal}
