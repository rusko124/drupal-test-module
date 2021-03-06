<?php
/**
 * @file
 * Contains Drupal/simple_notes/StatusChangeNote.
 */

namespace Drupal\simple_notes;
use Drupal\node\Entity\Node;

/**
 *This class for banch.
 *Change status to Actual or Expired.
 */
class StatusChangeNote {

  /**
   *This function compares the time specified by the user and the creation time of the note. 
   *And changes the status.
   */
  public static function statusChangeTo($nids, $time, &$context){
    $message = 'Changing status ...'; 

    $term_name = 'Actual';
    $term = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadByProperties(['name' => $term_name,'vid' => 'status_note']);
    $term_key_actual = key($term);

    $term_name = 'Expired';
    $term = \Drupal::entityTypeManager()
      ->getStorage('taxonomy_term')
      ->loadByProperties(['name' => $term_name,'vid' => 'status_note']);
    $term_key_expired = key($term);

    $results = array();
    $nodes = entity_load_multiple('node', $nids);
    foreach ($nodes as $node) {
      $timestamp_node = (int)$node->revision_timestamp->value;
      if ($timestamp_node > $time->getTimestamp()) {
        $node->field_status->target_id = $term_key_actual;
        $results[] = $node->save();
      }
      else {
        $node->field_status->target_id = $term_key_expired;
        $results[] = $node->save();
      }
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   *This function Finised Callback for statusChangeTo function.
   */
  function statusChangeToFinishedCallback($success, $results, $operations) {
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One note status changed.', '@count notes status changed.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }

  /**
   *This batch function change status note to N/A.
   */
  public static function statusChangeToNull($nids, &$context){
    $message = 'Changing status to N/A...';
    $results = array();
    $nodes = entity_load_multiple('node', $nids);
    foreach ($nodes as $node) {
      $node->field_status->target_id = 0;
      $results[] = $node->save();
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   *This function Finised Callback for statusChangeToNull function.
   */
  function statusChangeToNullFinishedCallback($success, $results, $operations) {
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One note status changed to N/A.', '@count notes status changed to N/A.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }
}
