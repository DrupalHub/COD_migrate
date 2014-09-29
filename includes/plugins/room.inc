<?php

/**
 * Contains Room.
 *
 * Handling the migration process for the Event room entity.
 */
class RoomDestination extends MigrateDestinationEntity {

  /**
   * Basic initialization
   *
   * @param array $options
   *  Options applied to comments.
   */
  public function __construct(array $options = array()) {
    parent::__construct('room', '', $options);
  }

  static public function getKeySchema() {
    return array(
      'evtrid' => array(
        'type' => 'int',
        'unsigned' => TRUE,
        'description' => 'ID of destination room',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'name' => t('The name of the room'),
      'capacity' => t('Amount of people for the room'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function import(stdClass $object, stdClass $row) {
    $entity = entity_create('cod_event_room', $row);
    $this->prepare($entity, $row);
    entity_save('cod_event_room', $entity);
    $this->complete($entity, $row);

    return array($entity->evtrid);
  }
}
