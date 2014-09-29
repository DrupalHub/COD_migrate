<?php

/**
 * @file
 * COD migrate file.
 */

abstract class CODMigrate extends Migration {
  public $entityType;
  public $bundle;

  function __construct() {
    parent::__construct();
    $this->description = t('Import @type - @bundle from CSV file.', array('@type' => $this->entityType, '@bundle' => $this->bundle));

  if ($this->entityType == 'taxonomy_term') {
    $class_name = 'MigrateDestinationTerm';

    $this->csvColumns = array(
      array('id', 'ID'),
      array('name', 'Name'),
      array('description', 'Description'),
    );
    $this->addFieldMapping('name', 'name');
    $this->addFieldMapping('description', 'description');
  }
  else {
    $class_name = 'MigrateDestinationNode';
  }

    // Create a map object for tracking the relationships between source rows
    $key = array(
      'id' => array(
        'type' => 'varchar',
        'length' => 255,
        'not null' => TRUE,
      ),
    );
    $this->map = new MigrateSQLMap($this->machineName, $key, MigrateDestinationNode::getKeySchema($this->entityType));

    // Create a MigrateSource object.
    $this->source = new MigrateSourceCSV(drupal_get_path('module', 'cod_migrate') . '/csv/' . $this->entityType . '/' . $this->bundle . '.csv', $this->csvColumns, array('header_rows' => 1));
    $this->destination = new $class_name($this->bundle, array('text_format' => 'filtered_html'));
  }

}
