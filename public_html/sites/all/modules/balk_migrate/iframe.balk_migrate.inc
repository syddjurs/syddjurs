<?php

class BalkIframeMigration extends BalkMigration {
  public function __construct() {
    parent::__construct();

    $this->description = t("Migrates the following content types: 'Selvbetjening'.");
    
    $query = $this->balk_query;
    $query->condition('objecttype', 'Selvbetjening', '=');
    
    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('iframe_selvbetjeningsl_sning_mm');
    
    // Field: iFrame URL (iFrame URL).
    $this->addFieldMapping('field_iframe_url', 'url');

    // Unmigrated source fields.
    $this->addUnmigratedSources(array('rightcol', 'imagename', 'imagename_file', 'filename', 'caption', 'gis_adresse', 'url', 'address', 'zipcity', 'email', 'phone', 'textline', 'publish_on', 'unpublish_on', 'category'), t('Do Not Migrate'));
  }
}
