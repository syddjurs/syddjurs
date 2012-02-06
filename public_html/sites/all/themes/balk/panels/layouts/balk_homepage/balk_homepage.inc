<?php

/**
 * Implements hook_panels_layouts().
 */
$plugin = array(
  'title' => t('Homepage'),
  'category' => t('Balk'),
  'icon' => 'balk_homepage.png',
  'theme' => 'panels_balk_homepage',
  'theme arguments' => array('id', 'content'),
  'admin css' => 'balk_homepage_admin.css',
  'regions' => array(
    'lead' => t('Lead'),
    'top_left' => t('Top left'),
    'top_center' => t('Top center'),
    'top_right' => t('Top right'),
    'middle_left' => t('Middle left'),
    'middle_right' => t('Middle right'),
    'bottom' => t('Bottom'),
  ),
);
