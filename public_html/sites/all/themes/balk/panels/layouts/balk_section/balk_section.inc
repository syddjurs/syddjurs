<?php

/**
 * Implements hook_panels_layouts().
 */
$plugin = array(
  'title' => t('Section'),
  'category' => t('Balk'),
  'icon' => 'balk_section.png',
  'theme' => 'panels_balk_section',
  'theme arguments' => array('id', 'content'),
  'admin css' => 'balk_section_admin.css',
  'regions' => array(
    'lead' => t('Lead'),
    'content' => t('Content'),
  ),
);
