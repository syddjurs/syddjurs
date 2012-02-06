<div<?php print $attributes; ?>>
  
  <?php print render($content['field_lead_image']); ?>
  
  <?php if (!$page && $title): ?>
  <div>
    <?php print render($title_prefix); ?>
    <h3<?php print $title_attributes; ?>><?php print $title ?></h3>
    <?php print render($title_suffix); ?>
  </div>
  <?php endif; ?>
  
  <?php
    // We hide the comments, links and some fields.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_phone1']);
    hide($content['field_email']);
    print render($content);
  ?>
  
  <div class="field-name-field-phone1">T: <?php print $content['field_phone1'][0]['#markup']; ?></div>
  <div class="field-name-field-email">E: <?php print $content['field_email'][0]['#markup']; ?></div>
  
</div>
