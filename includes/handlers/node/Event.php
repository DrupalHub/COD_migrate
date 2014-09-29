<?php

class Event extends CODMigrate {
  public $entityType = 'node';
  public $bundle = 'event';

  public $csvColumns = array(
    array('id', 'ID'),
    array('title', 'Title'),
    array('body', 'Body'),
    array('start_date', 'Start date'),
    array('end_date', 'End date'),
    array('field_event_image', 'Image'),
    array('field_event_default_session_view', 'Session view'),
    array('field_event_tickets', 'Tickets'),
    array('uid', 'User'),
  );

  public $dependencies = array('User');

  public function __construct() {
    parent::__construct();

    $this->addFieldMapping('title', 'title');
    $this->addFieldMapping('body', 'body');
    $this->addFieldMapping('start_date', 'start_date');
    $this->addFieldMapping('end_date', 'end_date');
    $this->addFieldMapping('field_event_image', 'field_event_image');
    $this->addFieldMapping('field_event_image:file_replace')
      ->defaultValue(FILE_EXISTS_REPLACE);
    $this->addFieldMapping('field_event_image:source_dir')
      ->defaultValue(drupal_get_path('module', 'cod_migrate') . '/includes/images/nodes');
    $this->addFieldMapping('field_event_image:destination_dir', 'destination');

    $this->addFieldMapping('uid', 'uid')
      ->sourceMigration('User');
  }

  /**
   * Prepare. Convert the date into timestamp.
   */
  public function prepare($entity, $row) {
    $timestamp = array(
      'value' => strtotime($row->start_date),
      'value2' => strtotime($row->end_date),
      'timezone' => date_default_timezone(),
      'timezone_db' => date_default_timezone(),
      'date_type' => 'datestamp',
    );

    $wrapper = entity_metadata_wrapper('node', $entity);
    $wrapper->field_dates->set($timestamp);
  }
}
