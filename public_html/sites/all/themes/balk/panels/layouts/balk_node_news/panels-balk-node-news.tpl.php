<div class="panel-display container-16 panel-node-news" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="panel-panel grid-13 alpha omega panel-region-lead">
    <div class="inside"><?php print $content['lead']; ?></div>
  </div>

  <div class="panel-panel grid-8 alpha panel-region-middle">
    <div class="inside"><?php print $content['middle']; ?></div>
  </div>

  <div class="panel-panel grid-5 omega panel-region-right">
    <div class="inside"><?php print $content['right']; ?></div>
  </div>
</div>
