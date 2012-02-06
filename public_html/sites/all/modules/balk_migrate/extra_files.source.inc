<?php

class ExtraFilesMigrateSource extends MigrateSource {
  private $key;
  private $imported_files;
  private $files;

  /**
   * Simple initialization.
   */
  public function __construct($options = array()) {
    parent::__construct($options);

    $dir = conf_path() . "/files/m";
    $mask = '/.*/';

    // All imported files.
    $files = file_scan_directory($dir, $mask, array('key' => 'filename'));
    
    $this->imported_files = $files;

    // All current files (including some that are already migrated).
    $existing_files = db_select('file_managed', 'fm', array('fetch' => PDO::FETCH_ASSOC))
      ->fields('fm', array('filename'))
      ->execute()
      ->fetchAllAssoc('filename');

    // The files that have to be imported.
    $actual_files = array_diff_key($files, $existing_files);

    $this->files = array_values($actual_files);
  }

  public function __toString() {
    return "Imports extra files.";
  }

  /**
   * Derived classes must implement fields(), returning a list of available
   * source fields.
   *
   * @return array
   *  Keys: machine names of the fields (to be passed to addFieldMapping)
   *  Values: Human-friendly descriptions of the fields.
   */
  public function fields() {
    return array(
      'uri' => 'uri',
      'filename' => 'filename',
      'name' => 'name',
    );
  }

  /**
   * Run at the beginning of the loop.
   */
  public function rewind() {
    $this->key = 0;
    $this->next();
  }

  /**
   * Returns the number of nodes that will be created.
   */
  public function computeCount() {
    return count($this->imported_files);
  }

  /**
   * Activities to happen within the loop.  Be sure to set currentRow (a stdClass) and currentKey (an array).
   * Return value is ignored.
   */
  public function next() {
    if (isset($this->files[$this->key])) {
      $file = $this->files[$this->key];
      
      $tmp_uri = explode('/', $file->uri);
      $uri = $tmp_uri[count($tmp_uri) - 2] . '/' . $tmp_uri[count($tmp_uri) - 1];
      
      $this->currentRow = new stdClass();
      $this->currentRow->imageid = $this->key;
      $this->currentRow->uri = file_default_scheme() . '://m/' . $uri;
      $this->currentRow->filename = $file->filename;
      $this->currentRow->name = $file->name;

      $this->currentKey = array($this->key);
    }
    else {
      $this->currentRow = NULL;
    }

    $this->key++;
  }
}
