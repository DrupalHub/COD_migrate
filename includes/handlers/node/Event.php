<?php

class Event extends CODMigrate {
  public $entityType = 'node';
  public $bundle = 'event';

  public $csvColumns = array(
    array('id', 'ID'),
    array('title', 'Title'),
    array('field_dates', 'Dates'),
    array('field_event_image', 'Image'),
    array('field_event_program', 'Program'),
    array('field_event_tickets', 'Tickets'),
    array('field_event_default_session_view', 'Session view'),
    array('uid', 'User'),
  );

  public $dependencies = array('User');

  public function __construct() {
    parent::__construct();

    $this->addFieldMapping('title', 'title');
    $this->addFieldMapping('body', 'body');
    $this->addFieldMapping('field_event_image', 'logo');
    $this->addFieldMapping('field_event_image:file_replace')
      ->defaultValue(FILE_EXISTS_REPLACE);
    $this->addFieldMapping('field_event_image:source_dir')
      ->defaultValue(drupal_get_path('module', 'cod_migrate') . '/includes/images/nodes');
    $this->addFieldMapping('field_event_image:destination_dir', 'destination');

    $this->addFieldMapping('uid', 'uid')
      ->sourceMigration('User');
  }
}
