<div<?php print $attributes; ?>>
  <div<?php print $content_attributes; ?>>
    <div class="branding-data clearfix">
      <?php if (isset($linked_logo_img)): ?>
      <div class="logo-img">
        <?php print $linked_logo_img; ?>
      </div>
      <?php endif; ?>
    </div>
    <?php print $content; ?>
  </div>
</div>