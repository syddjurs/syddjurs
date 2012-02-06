<?php if ($view->row_index != 0): ?>
  <?php unset($fields['field_lead_image']); ?>
  <?php unset($fields['field_resume_long']); ?>
<?php endif; ?>

<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php print $field->content; ?>
  <?php print $field->wrapper_suffix; ?>
<?php endforeach; ?>