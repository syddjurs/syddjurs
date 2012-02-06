<div<?php print $attributes; ?>>
  <?php
    $node_path = 'node/' . $nid;
    if (isset($content['field_external_link'])) {
      $node_path = $content['field_external_link']['#items'][0]['value'];
    }
    elseif (isset($content['field_attached_node'])) {
      $node_path = 'node/' . $content['field_attached_node']['#items'][0]['nid'];
    }

    $content['field_lead_image'][0]['#path'] = array(
      'path' => $node_path,
    );
  ?>
  <?php print render($content['field_lead_image']); ?>
  
  <?php if (!$page && $title): ?>
  <div class="tema-wrapper">
    <?php print render($title_prefix); ?>
    <h2<?php print $title_attributes; ?>><?php print l($title, $node_path); ?></h2>
    <?php print render($title_suffix); ?>
    
    <?php
      // We hide the comments, links and some fields.
      hide($content['field_attached_node']);
      hide($content['field_external_link']);
      hide($content['comments']);
      hide($content['links']);
      print render($content);
    ?>
  </div>
  <?php endif; ?>
</div>
