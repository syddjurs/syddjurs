<?php

/**
 * Implements hook_panels_layouts().
 */
$plugin = array(
  'title' => t('Node: News'),
  'category' => t('Balk'),
  'icon' => 'balk_node_news.png',
  'theme' => 'panels_balk_node_news',
  'theme arguments' => array('id', 'content'),
  'admin css' => 'balk_node_news_admin.css',
  'regions' => array(
    'lead' => t('Lead'),
    'middle' => t('Middle'),
    'right' => t('Right'),
  ),
);
