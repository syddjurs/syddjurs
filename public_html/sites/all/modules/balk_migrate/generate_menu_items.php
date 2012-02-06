<?php
set_time_limit(0);

// Change script directory to the actual Drupal root.
chdir ('../');
chdir ('../');
chdir ('../');
chdir ('../');

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);


// Get parent subsite items.
$subsites = db_select('siab_content', 'c', array('fetch' => PDO::FETCH_ASSOC))
  ->fields('c', array('oid', 'name'))
  ->condition('objecttype', 'Ny Subsite Forside')
  ->execute()
  ->fetchAll();

foreach ($subsites as $key => $subsite) {
  $menu_item_mlid = db_select('menu_links', 'ml', array('fetch' => PDO::FETCH_ASSOC))
    ->condition('ml.menu_name', 'main-menu')
    ->condition('ml.link_title', $subsite['name'], '=')
    ->fields('ml', array('mlid'))
    ->execute()
    ->fetchField();
  
  $taxonomy_term_tid = db_select('taxonomy_term_data', 'ttd', array('fetch' => PDO::FETCH_ASSOC))
    ->condition('ttd.vid', 8)
    ->condition('ttd.name', $subsite['name'], '=')
    ->fields('ttd', array('tid'))
    ->execute()
    ->fetchField();
  $context = array('tids' => array($taxonomy_term_tid));
  
  if ($menu_item_mlid) {
    // Create a menu link for each subsite frontpage.
    $node = balk_migrate_get_nid($subsite['oid']);
    
    if ($node) {
      $node = node_load($node->nid);
      $menu_link = array(
        'menu_name'  => 'main-menu',
        'link_title' => $subsite['name'],
        'link_path'  => drupal_get_normal_path('node/' . $node->nid),
        'plid'       => $menu_item_mlid,
        'weight'     => -50
      );

      // Save the item to database.
      menu_link_save($menu_link);
      
      // Assign the node to a site_structure section.
      balk_custom_node_assign_term_action($node, $context);

      // Call recursive function that creates a menu item for each children.
      balk_migrate_create_menu_items($subsite['oid'], $menu_item_mlid, $context);
    }
  }
}

function balk_migrate_create_menu_items($parent_oid, $plid, $context) {
  $children = db_select('tree', 't', array('fetch' => PDO::FETCH_ASSOC))
    ->fields('t', array('child_oid'))
    ->condition('parent_oid', $parent_oid)
    ->distinct()
    ->execute()
    ->fetchAll();
  
  if ($children) {
    foreach ($children as $key => $child) {
      $node = balk_migrate_get_nid($child['child_oid']);
      
      if ($node) {
        $node = node_load($node->nid);
        $menu_link = array(
          'menu_name'  => 'main-menu',
          'link_title' => $node->title,
          'link_path'  => drupal_get_normal_path('node/' . $node->nid),
          'plid'       => $plid,
        );

        // Save the item to database.
//        $new_plid = $plid;
        $new_plid = menu_link_save($menu_link);
        
        // Assign the node to a site_structure section.
        balk_custom_node_assign_term_action($node, $context);

        // Call recursive function that creates a menu item for each children.
        balk_migrate_create_menu_items($child['child_oid'], $new_plid, $context);
      }
    }
  }
}

function balk_migrate_get_nid($oid) {
  return db_query("SELECT destination_id AS nid FROM {balk_migrate_source_uri_map} WHERE source_id = :source_id", array(':source_id' => $oid))->fetchObject();
}

menu_cache_clear_all();

exit();

//$root_map = array(
//  // Borgertorvet
//  '49438' => '1353',
//  // By, bolig & trafik
//  '47181' => '1354',
//  // Børn & Unge
//  '45363' => '1962',
//  // Job & Uddannelse
//  '46600' => '1963',
//  // Kultur & Fritid
//  '43430' => '1964',
//  // Natur, Miljø & Affald
//  '42962' => '1965',
//  // Sundhed & Forebyggelse
//  '49768' => '1966',
//  // Handicap
//  '' => '1967', // Missing from siab_content
//  // Ældre & Pleje
//  '49327' => '1968',
//  // Vand - Forsyning
//  '' => '2167', // Missing from siab_content
//  // Vand & Afløb
//  '' => '2168', // Missing from siab_content
//  // Om Ballerup
//  '44250' => '2169',
//);
