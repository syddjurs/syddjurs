<div class="panel-display container-16 panel-homepage" <?php if (!empty($css_id)) { print "id=\"$css_id\""; } ?>>
  <div class="panel-panel grid-16 panel-region-lead">
    <div class="inside"><?php print $content['lead']; ?></div>
  </div>
  
  <div class="panel-region-top clearfix">
    <div class="panel-panel grid-5 panel-region-top-left">
      <div class="inside"><?php print $content['top_left']; ?></div>
    </div>
    
    <div class="panel-panel grid-5 panel-region-top-center">
      <div class="inside"><?php print $content['top_center']; ?></div>
    </div>
    
    <div class="panel-panel grid-5 panel-region-top-right">
      <div class="inside"><?php print $content['top_right']; ?></div>
    </div>
  </div>
  
  <div class="panel-region-middle clearfix">
      <div class="panel-panel grid-10 panel-region-middle-left">
        <div class="inside"><?php print $content['middle_left']; ?></div>
      </div>

      <div class="panel-panel grid-6 panel-region-middle-right">
        <div class="inside"><?php print $content['middle_right']; ?></div>
      </div>
  </div>
  
  <div class="panel-panel grid-16 panel-region-bottom">
    <div class="inside"><?php print $content['bottom']; ?></div>
  </div>
</div>
