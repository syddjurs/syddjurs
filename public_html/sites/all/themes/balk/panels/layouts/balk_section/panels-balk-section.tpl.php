<div class="panel-display container-16 panel-section" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="panel-panel grid-13 alpha omega panel-region-lead">
    <div class="inside"><?php print $content['lead']; ?></div>
  </div>

  <div class="panel-panel grid-13 alpha omega panel-region-content">
    <div class="inside"><?php print $content['content']; ?></div>
  </div>
</div>
