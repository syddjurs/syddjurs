<?php

class BalkExtraFilesMigration extends Migration {
  public function __construct() {
    parent::__construct(MigrateGroup::getInstance('Balk'));
    $this->description = t('Extra files');

    $this->map = new MigrateSQLMap($this->machineName,
        array('imageid' => array(
                'type' => 'int',
                'unsigned' => TRUE,
                'not null' => FALSE,
                'description' => 'Image ID.'
                )
             ),
        MigrateDestinationFile::getKeySchema()
    );

    $this->source = new ExtraFilesMigrateSource();

    // TIP: Set copy_file to copy the file from its source (which could be a
    // remote server, i.e. the uri is of the form http://example.com/images/foo.jpg).
    $this->destination = new BalkMigrateDestinationFile(array('copy_file' => TRUE));

    // Just map the incoming filename to the destination's 'uri'.
    $this->addFieldMapping('uri', 'uri');
    $this->addFieldMapping('filename', 'filename');

    $this->addFieldMapping('uid')->defaultValue(1);    

    $this->addUnmigratedSources(array('name'));
    
    $this->addUnmigratedDestinations(array('fid', 'status',
      'contents', 'filemime', 'timestamp', 'path'));
  }

  public function prepareRow($row) {
    parent::prepareRow($row);
    
    
//    $row->category = trim($row->category, ';');
  }  
}
