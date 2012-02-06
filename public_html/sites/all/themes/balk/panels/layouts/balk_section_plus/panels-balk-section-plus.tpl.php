<div class="panel-display container-16 panel-section" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="panel-panel grid-13 alpha omega panel-region-lead">
    <div class="inside"><?php print $content['lead']; ?></div>
  </div>

  <div class="panel-panel grid-9 alpha panel-region-top-left">
    <div class="inside"><?php print $content['top_left']; ?></div>
  </div>
  <div class="panel-panel grid-4 omega panel-region-top-right">
    <div class="inside"><?php print $content['top_right']; ?></div>
  </div>

  <div class="panel-panel grid-13 alpha omega panel-region-content">
    <div class="inside"><?php print $content['content']; ?></div>
  </div>
</div>
