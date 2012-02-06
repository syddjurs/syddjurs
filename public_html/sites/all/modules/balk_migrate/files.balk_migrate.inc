<?php

class BalkFilesMigration extends BalkMigration {
  public function __construct() {
    parent::__construct();

    $this->description = t("Migrates the following content types: 'Dokument-fil'.");
    
    $query = $this->balk_query;
    $query->condition('objecttype', 'Dokument-fil', '=');
    
    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('files');

    // Field: Lead Image (Primære billede).
    $arguments = MigrateFileFieldHandler::arguments(file_default_scheme() . '://m/',
      'file_copy', FILE_EXISTS_RENAME, NULL, NULL,
      NULL, array('source_field' => 'filename'));
    $this->addFieldMapping('field_lead_image', 'imagename')
         ->arguments($arguments);
    
    // Field: Files (Filer).
    $arguments = MigrateFileFieldHandler::arguments(file_default_scheme() . '://m/',
      'file_copy', FILE_EXISTS_RENAME, NULL, NULL,
      NULL, array('source_field' => 'filename'));
    $this->addFieldMapping('field_file', 'imagename_file')
         ->arguments($arguments);
    $this->addFieldMapping(NULL, 'filename');

    // Unmigrated source fields.
    $this->addUnmigratedSources(array('rightcol', 'caption', 'gis_adresse', 'url', 'address', 'zipcity', 'email', 'phone', 'textline', 'publish_on', 'unpublish_on', 'category'), t('Do Not Migrate'));
  }
}
