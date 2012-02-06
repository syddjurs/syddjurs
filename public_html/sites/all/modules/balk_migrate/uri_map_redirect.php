<?php

// Based on custom patterns, build the destination_uri for given source_uri
function migrate_build_url($destid1, $migration_name) {
  global $base_url;

  $pattern = 'node/:source_id';

  // Swap in the destination ID.
  $destination_uri = str_replace(':source_id', $destid1, $pattern);

  // For speed, we go right to aliases table rather than more bootstrapping.
  if ($uri_clean = db_query("SELECT alias FROM {url_alias} WHERE source = :destination_uri", array(':destination_uri' => $destination_uri))->fetchField()) {
    $destination_uri = $uri_clean;
  }

  // Build absolute url for 301 redirect.
  return  $base_url . '/' . $destination_uri;
}

define('DRUPAL_ROOT', getcwd());
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';

// Only bootstrap to DB so we are as fast as possible. Much of the Drupal API
// is not available to us.
drupal_bootstrap(DRUPAL_BOOTSTRAP_DATABASE);

// You must populate this querystring param from a rewrite rule or $_SERVER
if (!$source_id = $_GET['migrate_source_id']) {
  print '$_GET[migrate_source_uri] was not found on the request.';
  exit();
}

if ($uri_map = db_query("SELECT destination_id FROM {balk_migrate_source_uri_map} WHERE source_id = :source_id", array(':source_id' => $source_id))->fetchObject()) {
  // Hurray, we do recognize this URI.
  header('Location: ' . migrate_build_url($uri_map->destination_id, $uri_map->migration_name), TRUE, 301);
}
else {
  // Can't find the source URI.
  header('Status=Not Found', TRUE, 404);
  print '<h1>404 - Not found.</h1>';
}
