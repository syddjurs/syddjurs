<div<?php print $attributes; ?>>
  <?php
    // We hide the comments and links.
    hide($content['comments']);
    hide($content['links']);
    print render($content);
  ?>
</div>
