<?php

/**
 * Migrating users.
 */
class Time extends Migration {

  public $csvColumns = array(
    array('id', 'ID'),
    array('label', 'label'),
  );

  public function __construct() {
    parent::__construct();
    $this->description = t('Import time slots from a CSV file.');

    $this->addFieldMapping('label', 'label');

    // Create a map object for tracking the relationships between source rows
    $key = array(
      'id' => array(
        'type' => 'varchar',
        'length' => 255,
        'not null' => TRUE,
      ),
    );
    $destination_handler = new TimeDestination();
    $this->map = new MigrateSQLMap($this->machineName, $key, $destination_handler->getKeySchema());

    // Create a MigrateSource object.
    $this->source = new MigrateSourceCSV(drupal_get_path('module', 'cod_migrate') . '/csv/entities/time.csv', $this->csvColumns, array('header_rows' => 1));
    $this->destination = new TimeDestination();
  }

}
