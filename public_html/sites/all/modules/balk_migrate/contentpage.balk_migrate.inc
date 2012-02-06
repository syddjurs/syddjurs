<?php

class BalkContentpageMigration extends BalkMigration {
  public function __construct() {
    parent::__construct();

    $this->description = t("Migrates the following content types: 'Ny Side', 'Indholdsside', 'Kort tekst', 'Lang tekst'.");
    
    $query = $this->balk_query;
    $query->condition('objecttype', array('Ny Side', 'Indholdsside', 'Kort tekst', 'Lang tekst', 'Ny Subsite Forside'), 'IN');
    
    $this->source = new MigrateSourceSQL($query);
    $this->destination = new MigrateDestinationNode('contentpage');
    
    // Field: Additional info (Højrespalte, unik).
    $summary_arguments = MigrateTextFieldHandler::arguments(NULL, filter_default_format(), NULL);
    $this->addFieldMapping('field_additional_info', 'rightcol')
      ->arguments($summary_arguments);
    
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
    $this->addFieldMapping('field_files', 'imagename_file')
         ->arguments($arguments);
    $this->addFieldMapping(NULL, 'filename');

    // Unmigrated destination fields.
    $this->addUnmigratedDestinations(array('field_related', 'field_related_person', 'field_right_column', 'field_site_structure'), t('Do Not Migrate'));
    
    // Unmigrated source fields.
    $this->addUnmigratedSources(array('caption', 'gis_adresse', 'url', 'address', 'zipcity', 'email', 'phone', 'textline', 'publish_on', 'unpublish_on', 'category'), t('Do Not Migrate'));
  }
}
