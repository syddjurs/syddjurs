<?php

/**
 * Implements hook_panels_layouts().
 */
$plugin = array(
  'title' => t('Section Plus'),
  'category' => t('Balk'),
  'icon' => 'balk_section_plus.png',
  'theme' => 'panels_balk_section_plus',
  'theme arguments' => array('id', 'content'),
  'admin css' => 'balk_section_plus_admin.css',
  'regions' => array(
    'lead' => t('Lead'),
    'top_left' => t('Top left'),
    'top_right' => t('Top right'),
    'content' => t('Content'),
  ),
);
