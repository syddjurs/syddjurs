<?php

/**
 * Implements hook_panels_layouts().
 */
$plugin = array(
  'title' => t('Node'),
  'category' => t('Balk'),
  'icon' => 'balk_node.png',
  'theme' => 'panels_balk_node',
  'theme arguments' => array('id', 'content'),
  'admin css' => 'balk_node_admin.css',
  'regions' => array(
    'lead' => t('Lead'),
    'middle_top' => t('Middle top'),
    'middle_center' => t('Middle center'),
    'middle_right' => t('Middle right'),
  ),
);
