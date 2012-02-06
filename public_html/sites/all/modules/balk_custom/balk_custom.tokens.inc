<?php

 /**
 * @file
 * Token callbacks for the balk_custom module.
 */

/**
 * Implements hook_token_info().
 */
function balk_custom_token_info() {
  // Additional node tokens.
  $info['tokens']['node']['site-structure-path'] = array(
    'name' => t('Site structure path'),
    'description' => t("The path of the first assigned term from the Placering vocabulary."),
  );
  $info['tokens']['node']['custom-created-date'] = array(
    'name' => t('Custom created date'),
    'description' => t("Custom string for the node creation date."),
  );
    $info["types"]['julekort'] = array(
      'name' => t("Julekort tokens"),
      'description' => ''
  );
  $info["tokens"]['julekort']['to_name'] = array(
      'name' => t("To name"),
      'description' => ''
  );
  $info["tokens"]['julekort']['from_name'] = array(
      'name' => t("From name"),
      'description' => ''
  );
  $info["tokens"]['julekort']['to_email'] = array(
      'name' => t("To email"),
      'description' => ''
  );
  $info["tokens"]['julekort']['from_email'] = array(
      'name' => t("From email"),
      'description' => ''
  );
  $info["tokens"]['julekort']['greeting_text'] = array(
      'name' => t("Greeting text"),
      'description' => ''
  );

  return $info;
}

/**
 * Implements hook_tokens().
 */
function balk_custom_tokens($type, $tokens, array $data = array(), array $options = array()) {
  $replacements = array();
  $sanitize = !empty($options['sanitize']);

  // Node tokens.
  if ($type == 'node' && !empty($data['node'])) {
    $node = $data['node'];

    foreach ($tokens as $name => $original) {
      switch ($name) {
        case 'site-structure-path':
          $tid = reset(field_get_items('node', $node, 'field_site_structure'));
          $site_structure_path = '';
          if (!empty($tid)) {
            $site_structure_path = url('taxonomy/term/' . $tid['tid']);
          }
          $replacements[$original] = trim($site_structure_path, '/');
          break;
        case 'custom-created-date':
          // Author information was not needed anymore, leaving here for reference.
//          $replacements[$original] = '<p class="custom-created-date-date">' . format_date($node->created, 'custom', 'd M Y') . '</p><p class="custom-created-date-author">af ' . theme('username', array('account' => $node)) . '</p>';
          $replacements[$original] = '<p class="custom-created-date-date">' . format_date($node->created, 'custom', 'd M Y') . '</p>';
          break;
      }
    }
  }
  
    if ($type == 'julekort') {
    foreach ($tokens as $name => $original) {
      if (array_key_exists($name, $data["julekort"]))
        $replacements[$original] = $data["julekort"][$name];
    }
  }

  return $replacements;
}
