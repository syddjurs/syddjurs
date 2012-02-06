<?php

/**
 * @file
 * This file is empty by default because the base theme chain (Alpha & Omega) provides
 * all the basic functionality. However, in case you wish to customize the output that Drupal
 * generates through Alpha & Omega this file is a good place to do so.
 * 
 * Alpha comes with a neat solution for keeping this file as clean as possible while the code
 * for your subtheme grows. Please read the README.txt in the /preprocess and /process subfolders
 * for more information on this topic.
 */

/**
 * Implements hook_preprocess_html().
 */
function balk_preprocess_html(&$variables) {
  // Add conditional stylesheets for IE.
  drupal_add_css(path_to_theme() . '/css/style-ie7.css', array('group' => CSS_THEME, 'browsers' => array('IE' => 'lte IE 7', '!IE' => FALSE), 'preprocess' => FALSE));

  // Add body classes for level 1 menu items.
  $trail = menu_get_active_trail();
  if (!empty($trail[1]['options']['attributes']['class'])) {
    foreach ($trail[1]['options']['attributes']['class'] as $menu_class) {
      $variables['attributes_array']['class'][] = drupal_html_class('context-menu-' . $menu_class);
    }
  }
}

/**
 * Implements THEMENAME_alpha_process_HOOK().
 */
function balk_alpha_process_region(&$variables) {
  if (drupal_is_front_page() && $variables['region'] == 'content') {
    $variables['attributes'] = ' class="region region-content" id="region-content"';
  }
}

/**
 * Implements hook_page_alter().
 */
function balk_page_alter(&$variables) {
  // Add the Kontakt block displayed on the right hand side.
  $variables['page_bottom']['ballerup_contact_block'] = array(
    '#type' => 'markup',
    '#markup' => '<a class="ballerup-contact-block" href="' . url('kontakt') . '"></a>',
  );
}

/**
 * Implements hook_preprocess_page().
 */
function balk_preprocess_page(&$variables) {
  // Hide the title if we are on a page managed by Panels (Page manager).
  if (module_exists('page_manager') && ($page_manager = page_manager_get_current_page())) {
    if ($page_manager['name'] != 'term_view') {
      $variables['title_hidden'] = TRUE;
    }
  }
}

/**
 * Implements hook_preprocess_node().
 */
function balk_preprocess_node(&$variables) {
  // Create the $updated variable.
  $variables['updated'] = t('Last updated on !datetime', array('!datetime' => format_date($variables['changed'], 'custom', 'd M Y'), '!username' => $variables['name']));
  
  // Add template suggestions for view modes.
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['node']->type . '__' . $variables['view_mode'];
}

/**
 * Implements hook_preprocess_panels_pane().
 */
function balk_preprocess_panels_pane(&$variables) {
  if ($variables['pane']->type == 'views' && $variables['pane']->subtype == 'activities') {
    $variables['theme_hook_suggestions'][] = 'panels_pane__activities_block';
  }
}

/**
 * Implements THEME_menu_link__menu_block__$hook_menu_name().
 *
 * Renders the main menu.
 */
function balk_menu_link__menu_block__main_menu(&$variables) {
  $element = $variables['element'];
  $sub_menu = '';
  $description  = '';
  $split_tree = '';

  // Add the link classes to the parent <li> element too.
  if (!empty($element['#attributes']['class']) && !empty($element['#original_link']['localized_options']['attributes']['class'])) {
    $element['#attributes']['class'] = array_merge($element['#attributes']['class'], (array) $element['#original_link']['localized_options']['attributes']['class']);
  }

  // Show menu item description.
  if (isset($element['#bid']) && ($element['#bid']['delta'] == '7') && !empty($element['#localized_options']['attributes']['title'])) {
    $description = '<span class="desc">' . $element['#localized_options']['attributes']['title'] . '</span>';
  }
  
  // Split the menu tree when the 'split' class is encountered.
  if (isset($element['#attributes']['class']) && in_array('split', $element['#attributes']['class'])) {
    $split_tree = "</ul>\n<ul class=\"menu\">";
  }
  
  // Add jump menus for the main links.
  $jump_menus = NULL;
  if (in_array('l1', $element['#attributes']['class'])) {
    $jump_menu = balk_get_jump_menus($element);
    if (!empty($jump_menu)) {
      $jump_menus = '<div class="main-menu-jump-menus">' . implode("\n", $jump_menu) . '</div>';
    }
  }

  if ($element['#below']) {
    $sub_menu = '<div class="submenu">' . drupal_render($element['#below']) . $jump_menus . '</div>';
  }
  $output = l($element['#title'], $element['#href'], $element['#localized_options']);

  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $description . $sub_menu . "</li>\n" . $split_tree;
}

/**
 * Implements THEME_views_view_field__VIEWID__DISPLAY__FIELD().
 *
 * Rewrites the URLs for Tema nodes to link to their external url or 'attached'
 * node for the Ballerup Taxonomy Term View.
 */
function balk_views_view_field__ballerup_taxonomy_term__block_4__title($variables) {
  $view = $variables['view'];
  $field = $variables['field'];
  $row = $variables['row'];
  if (!empty($view->result[$view->row_index]->field_field_external_link)) {
    $alter = $field->options['alter'];
    $alter['path'] = $view->result[$view->row_index]->field_field_external_link[0]['raw']['value'];
    $alter['external'] = TRUE;
    
    return $field->render_as_link($alter, $field->original_value, $field->last_tokens);
  }
  elseif (!empty($view->result[$view->row_index]->field_field_attached_node)) {
    $alter = $field->options['alter'];
    $alter['path'] = 'node/' . $view->result[$view->row_index]->field_field_attached_node[0]['raw']['nid'];
    
    return $field->render_as_link($alter, $field->original_value, $field->last_tokens);
  }
  
  return $variables['output'];
}

/**
 * Implements THEME_views_view_field__VIEWID__DISPLAY__FIELD().
 *
 * Rewrites the URLs for Tema nodes to link to their external url or 'attached'
 * node for the Tema View.
 */
function balk_views_view_field__campaigns__block_1__title($variables) {
  $view = $variables['view'];
  $field = $variables['field'];
  $row = $variables['row'];
  if (!empty($view->result[$view->row_index]->field_field_external_link)) {
    $alter = $field->options['alter'];
    $alter['path'] = $view->result[$view->row_index]->field_field_external_link[0]['raw']['value'];
    $alter['external'] = TRUE;
    
    return $field->render_as_link($alter, $field->original_value, $field->last_tokens);
  }
  
  return $variables['output'];
}



/**
 * Implements THEME_field__content_type().
 */
function balk_field__right_column($variables) {
  $output = '';

  // Render the label, if it's not hidden.
  if (!$variables['label_hidden']) {
    $output .= '<h2>' . $variables['label'] . '</h2>';
  }

  // Render the items.
  $output .= '<div class="field-items"' . $variables['content_attributes'] . '>';
  foreach ($variables['items'] as $delta => $item) {
    $classes = 'field-item ' . ($delta % 2 ? 'odd' : 'even');
    $output .= '<div class="' . $classes . '"' . $variables['item_attributes'][$delta] . '>' . drupal_render($item) . '</div>';
  }
  $output .= '</div>';

  // Render the top-level DIV.
  $output = '<div class="' . $variables['classes'] . '"' . $variables['attributes'] . '>' . $output . '</div>';

  return $output;
}

/**
 * Returns an array of jump menus for a top-level menu item.
 * 
 * @param array $element
 *   An menu item array, as provided by theme_menu_link().
 *
 * @return array
 *   An array of jump menus for this menu item.
 */
function balk_get_jump_menus($element) {
  $jump_menus = array();

  if (in_array('borger', $element['#attributes']['class'])) {
//    $jump_menus[] = balk_block_render('jump', 'menu-menu-selvbetjening');
    $jump_menus[] = balk_block_render('jump', 'menu-menu-borger-genveje');
  }
  elseif (in_array('kommunen', $element['#attributes']['class'])) {
    $jump_menus[] = balk_block_render('jump', 'menu-menu-erhverv-genveje');
  }
  elseif (in_array('erhverv', $element['#attributes']['class'])) {
    $jump_menus[] = balk_block_render('jump', 'menu-menu-erhverv-genveje2');
  }
  elseif (in_array('netsteder', $element['#attributes']['class'])) {
    $jump_menus[] = balk_block_render('jump', 'menu-menu-plejecenter');
    $jump_menus[] = balk_block_render('jump', 'menu-menu-botilbud');
    $jump_menus[] = balk_block_render('jump', 'menu-menu-bfo');
    $jump_menus[] = balk_block_render('jump', 'menu-menu-andre-netsteder');
  }

  return $jump_menus;
}

/**
 * Utility function for embedding a block in code.
 */
function balk_block_render($module, $block_id) {
  $block = block_load($module, $block_id);
  $block_content = _block_render_blocks(array($block));
  $build = _block_get_renderable_array($block_content);
  $block_rendered = drupal_render($build);
  
  return $block_rendered;
}

/**
 * Implements template_preprocess_views_view_row_rss().
 */
function balk_preprocess_views_view_row_rss(&$variables) {
  $item = &$variables['row'];
  foreach ($item->elements as $key => &$element) {
    if ($element['key'] == 'dc:creator' || $element['key'] == 'comments') {
      $element['value'] = '';
    }
  }
  $variables['item_elements'] = empty($item->elements) ? '' : format_xml_elements($item->elements);
}
