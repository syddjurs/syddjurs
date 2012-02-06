<?php

abstract class BalkMigration extends Migration {
  public function __construct() {
    parent::__construct(MigrateGroup::getInstance('Balk'));

    $this->balk_query = db_select('siab_content', 'c')
                        ->fields('c', array(
                          'oid',
                          'objecttype',
                          'name',
                          'updated',
                          'rightcol',
                          'imagename',
                          'imagename_file',
                          'created',
                          'body',
                          'subheading',
                          'path',
                          'caption',
                          'gis_adresse',
                          'url',
                          'filename',
                          'address',
                          'zipcity',
                          'email',
                          'phone',
                          'textline',
                          'publish_on',
                          'unpublish_on',
                          'category',
                          'rightcol_inherit',
                        ));
    
    $this->map = new MigrateSQLMap($this->machineName,
        array(
          'oid' => array('type' => 'int',
                          'not null' => TRUE,
                         )
        ),
        MigrateDestinationNode::getKeySchema()
      );
    
    // Node title.
    $this->addFieldMapping('title', 'name');
    
    // Node body.
    $body_arguments = MigrateTextFieldHandler::arguments(NULL, filter_default_format(), NULL);
    $this->addFieldMapping('body', 'body')
      ->arguments($body_arguments);
    
    // Node summary.
    $summary_arguments = MigrateTextFieldHandler::arguments(NULL, filter_default_format(), NULL);
    $this->addFieldMapping('field_resume_long', 'subheading')
      ->arguments($summary_arguments);
    
    // Node properties.
    $this->addFieldMapping('is_new')->defaultValue(TRUE);
    $this->addFieldMapping('revision')->defaultValue(TRUE);
    $this->addFieldMapping('status')->defaultValue(1);
    $this->addFieldMapping('promote')->defaultValue(0);
    $this->addFieldMapping('sticky')->defaultValue(0);
    $this->addFieldMapping('language')->defaultValue('da');
    $this->addFieldMapping('created', 'created');
    $this->addFieldMapping('changed', 'updated');

    // Node path and Pathauto setting.
    $this->addFieldMapping('path', 'path');
    $this->addFieldMapping('pathauto')->defaultValue('1');

    // Field: Source ID.
    $this->addFieldMapping('field_source_id', 'oid');

    // Unmigrated destination fields.
    $this->addUnmigratedDestinations(array('uid', 'revision_uid', 'comment'), t('Do Not Migrate'));
    
    // Unmigrated source fields.
    $this->addUnmigratedSources(array('objecttype', 'rightcol_inherit'), t('Do Not Migrate'));
  }

  public function prepareRow($row) {
    // Skip items with an empty title;
    $row->name = trim(strip_tags($row->name));
    if (!$row->name) {
      return FALSE;
    }
    
    // Fix erroneous null value in the 'body' and 'subheading' fields.
    if ($row->body == 'null') {
      $row->body = NULL;
    }
    if ($row->subheading == 'null') {
      $row->subheading = NULL;
    }
    if ($row->filename == 'null') {
      $row->filename = NULL;
    }
    if ($row->path == 'null') {
      $row->path = NULL;
    }
    
    // Strip HTML tags from the 'subheading' field.
    $row->subheading = strip_tags($row->subheading);
    
    // Source dates are in ISO format.
    $row->created = strtotime($row->created);
    $row->updated = strtotime($row->updated);
    
    // Inherit text for the 'rightcol' field from the parent node.
    if ($row->rightcol_inherit) {
      $row->rightcol = db_select('siab_content', 'c')
        ->fields('c', array('rightcol'))
        ->condition('oid', $row->rightcol_inherit)
        ->execute()
        ->fetchField();
    }
    
    // Prevent errors for missing files.
    $source_path = file_default_scheme() . '://m/';
    if (!file_exists($source_path . $row->imagename)) {
      $row->imagename = NULL;
    }
    if (!file_exists($source_path . $row->imagename_file)) {
      $row->imagename_file = NULL;
    }
  }
  
  public function complete($node, $row) {
    $save = FALSE;
    
    // Scheduler properties.
    if ($row->publish_on) {
      $node->publish_on = strtotime($row->publish_on);
      $save = TRUE;
    }
    
    if ($row->unpublish_on || isset($this->content_tree[$row->oid]['unpublish_on'])) {
      if ($row->unpublish_on) {
        $node->unpublish_on = strtotime($row->unpublish_on);
      }
      else {
        $node->unpublish_on = strtotime($this->content_tree[$row->oid]['unpublish_on']);
      }
      $save = TRUE;
      
      if ($node->unpublish_on <= REQUEST_TIME) {
        $node->status = 0;
      }
    }
    
    if ($save) {
      $changed = $node->changed;
      
      // Re-save with publish_on value.
      node_save($node);
      
      // Fix $node->changed value.
      db_update('node')
        ->fields(array('changed' => $changed))
        ->condition('nid', $node->nid)
        ->execute();
      $node->changed = $changed;
    }
    
    // Save the source and destination ids.
    db_insert('balk_migrate_source_uri_map')
      ->fields(array(
        'source_id' => $row->oid,
        'migration_name' => $this->getMachineName(),
        'destination_id' => $node->nid,
      ))
      ->execute();
  }

  protected function preImport() {
    // Generate a tree with 'publish_on' dates for source content.
    $tree_result = db_select('tree', 't', array('fetch' => PDO::FETCH_ASSOC))
      ->fields('t')
      ->distinct()
      ->execute()
      ->fetchAll();

    $siab_content_result = db_select('siab_content', 'c', array('fetch' => PDO::FETCH_ASSOC))
      ->fields('c', array('oid', 'unpublish_on'))
      ->execute()
      ->fetchAllAssoc('oid');


    foreach ($tree_result as $tree_row) {
      $tree[$tree_row['child_oid']]['parent'] = $tree_row['parent_oid'];
    }

    foreach ($siab_content_result as $child_id => $siab_row) {
      if (!empty($siab_row['unpublish_on'])) {
        $tree[$child_id]['unpublish_on'] = $siab_row['unpublish_on'];
      }
      else {
        $oid = $child_id;
        $finished = FALSE;
        while (!$finished) {
          if (isset($tree[$oid]['parent'])) {
            $parent_id = $tree[$oid]['parent'];
            if (!empty($siab_content_result[$parent_id]['unpublish_on'])) {
              $tree[$child_id]['unpublish_on'] = $siab_content_result[$parent_id]['unpublish_on'];
              $finished = TRUE;
            }
            elseif ($parent_id == 1 || !isset($tree[$parent_id])) {
              $finished = TRUE;
            }
            else {
              $oid = $tree[$parent_id]['parent'];

            }
          }
          else {
            $finished = TRUE;
          }
        }
      }
    }

    $this->content_tree = $tree;

    parent::preImport();
  }

  protected function postRollback() {
    parent::postRollback();

    // Delete uri map on rollback.
    db_delete('balk_migrate_source_uri_map')
      ->condition('migration_name', $this->getMachineName(), '=')
      ->execute();
  }
}
