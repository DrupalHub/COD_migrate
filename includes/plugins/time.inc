<?php

/**
 * Contains Room.
 *
 * Handling the migration process for the Event room entity.
 */
class TimeDestination extends MigrateDestinationEntity {

  /**
   * Basic initialization
   *
   * @param array $options
   *  Options applied to comments.
   */
  public function __construct(array $options = array()) {
    parent::__construct('cod_event_time', '', $options);
  }

  static public function getKeySchema() {
    return array(
      'evttid' => array(
        'type' => 'int',
        'unsigned' => TRUE,
        'description' => 'ID of destination time',
      ),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function fields() {
    return array(
      'label' => t('The label of the time slot'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function import(stdClass $object, stdClass $row) {
    $entity = entity_create('cod_event_time', array('status' => 1, 'date_label' => $row->label));
    $this->prepare($entity, $row);
    entity_save('cod_event_time', $entity);
    $this->complete($entity, $row);
    $this->numCreated++;
    return array($entity->evttid);
  }

  public function rollback($role) {
    entity_delete('cod_event_time', $role['destid1']);
  }
}
