<?php
namespace Drupal\simple_notes;
use Drupal\node\Entity\Node;

/**
 *This class for banch.
 *Change status to Actual or Expired.
 */
class StatusChangeNote {

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
    foreach ($nids as $nid) {
      $node = Node::load($nid);
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

  public static function statusChangeToNull($nids, &$context){
    $message = 'Changing status to N/A...';
    $results = array();
    foreach ($nids as $nid) {
      $node = Node::load($nid);
      $node->field_status->target_id = 0;
      $results[] = $node->save();
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

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
