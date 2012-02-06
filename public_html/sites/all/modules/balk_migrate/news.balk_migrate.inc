<?php

class BalkNewsMigration extends BalkMigration {
  public function __construct() {
    parent::__construct();

    $this->description = t("Migrates the following content types: 'Arkivnyhed', 'Nyhed'.");
    
    $query = $this->balk_query;
    $query->condition('objecttype', array('Arkivnyhed', 'Nyhed'), 'IN');
    
    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('news');

    // Field: Site Structure (Placering på site).
    $this->addFieldMapping('field_news_category', 'category')
      ->separator(';');
    
    // Field: Lead Image (Primære billede).
    $arguments = MigrateFileFieldHandler::arguments(file_default_scheme() . '://m/',
      'file_copy', FILE_EXISTS_RENAME, NULL, NULL,
      NULL, array('source_field' => 'filename'));
    $this->addFieldMapping('field_lead_image', 'imagename')
         ->arguments($arguments);
    $this->addFieldMapping(NULL, 'filename');
    
    // Field: Additional info (Højrespalte, unik).
    $summary_arguments = MigrateTextFieldHandler::arguments(NULL, filter_default_format(), NULL);
    $this->addFieldMapping('field_additional_info', 'rightcol')
      ->arguments($summary_arguments);   

    // Unmigrated destination fields.
    $this->addUnmigratedDestinations(array('field_site_structure', 'field_related', 'field_right_column', 'field_related_person'), t('Do Not Migrate'));

    // Unmigrated source fields.
    $this->addUnmigratedSources(array('imagename_file', 'caption', 'gis_adresse', 'url', 'address', 'zipcity', 'email', 'phone', 'textline', 'publish_on', 'unpublish_on'), t('Do Not Migrate'));
  }
  
  public function prepareRow($row) {
    parent::prepareRow($row);
    
    $row->category = trim($row->category, ';');
  }  
}
