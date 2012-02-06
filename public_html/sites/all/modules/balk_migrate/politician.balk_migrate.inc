<?php

class BalkPoliticianMigration extends BalkMigration {
  public function __construct() {
    parent::__construct();

    $this->description = t("Migrates the following content types: 'Politisk Person'.");
    
    $query = $this->balk_query;
    $query->condition('objecttype', 'Politisk Person', '=');
    
    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('politician');

    // Override the default 'body' field migration.
    $this->removeFieldMapping('body');
    
    $body_arguments = MigrateTextFieldHandler::arguments(NULL, filter_default_format(), NULL);
    $this->addFieldMapping('body', 'textline')
      ->arguments($body_arguments);

    // Field: Lead Image (Primære billede).
    $arguments = MigrateFileFieldHandler::arguments(file_default_scheme() . '://m/',
      'file_copy', FILE_EXISTS_RENAME, NULL, NULL,
      NULL, array('source_field' => 'filename'));
    $this->addFieldMapping('field_lead_image', 'imagename')
         ->arguments($arguments);
    $this->addFieldMapping(NULL, 'filename');
    
    // Field: Adress (Adresse).
    $this->addFieldMapping('field_adress', 'address');

    // The 'zipcity' source field has been concatenated with the 'address' field.
    $this->addFieldMapping(NULL, 'zipcity');

    // Field: Email (Email).
    $this->addFieldMapping('field_email', 'email');
    
    // Field: Phone 1 (Telefonnummer).
    $this->addFieldMapping('field_phone1', 'phone');
    
    // Field: URL (Hjemmeside).
    $this->addFieldMapping('field_url', 'url');
    
    $this->removeFieldMapping('field_resume_long');

    // Unmigrated destination fields.
    $this->addUnmigratedDestinations(array('field_phone2', 'field_colofon', 'field_member', 'field_party_membership', 'field_resume_long'), t('Do Not Migrate'));

    // Unmigrated source fields.
    $this->addUnmigratedSources(array('imagename_file', 'rightcol', 'body', 'subheading', 'caption', 'gis_adresse', 'publish_on', 'unpublish_on', 'category'), t('Do Not Migrate'));
  }

  public function prepareRow($row) {
    parent::prepareRow($row);
    
    $row->name = str_replace('<br />', ' - ', $row->name);
    $row->address .= ', ' . $row->zipcity;
    
    $row->phone = str_replace(' ', '', $row->phone);
  } 
}
