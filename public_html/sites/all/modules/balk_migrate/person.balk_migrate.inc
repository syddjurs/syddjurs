<?php

class BalkPersonMigration extends BalkMigration {
  public function __construct() {
    parent::__construct();

    $this->description = t("Migrates the following content types: 'Person'.");
    
    $query = $this->balk_query;
    $query->condition('objecttype', 'Person', '=');
    
    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('person');

    // Field: Lead Image (Primære billede).
    $arguments = MigrateFileFieldHandler::arguments('http://ballerup.dk/data/',
      'file_copy', FILE_EXISTS_RENAME, NULL, NULL,
      NULL, array('source_field' => 'filename'));
    $this->addFieldMapping('field_lead_image', 'imagename')
         ->arguments($arguments);
    $this->addFieldMapping(NULL, 'filename');
    
    $this->removeFieldMapping('field_resume_long');
    
    // Unmigrated destination fields.
    $this->addUnmigratedDestinations(array('field_resume_long', 'field_adress', 'field_email', 'field_phone1', 'field_phone2', 'field_short_description', 'field_url', 'field_organization', 'field_member'), t('Do Not Migrate'));

    // Unmigrated source fields.
    $this->addUnmigratedSources(array('imagename_file', 'rightcol', 'subheading', 'caption', 'gis_adresse', 'url', 'address', 'zipcity', 'email', 'phone', 'textline', 'publish_on', 'unpublish_on', 'category'), t('Do Not Migrate'));
  }

  public function prepareRow($row) {
    parent::prepareRow($row);
    
    $row->name = str_replace('<br />', ' - ', $row->name);
  }  
}
