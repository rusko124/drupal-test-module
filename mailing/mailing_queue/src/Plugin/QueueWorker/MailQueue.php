<?php
/**
 * @file
 * Contains \Drupal\mailing_queue\Plugin\QueueWorker\MailQueue.
 */
namespace Drupal\mailing_queue\Plugin\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
/**
 * Processes Tasks for mailing.
 *
 * @QueueWorker(
 *   id = "mail_queue",
 *   title = @Translation("Mailing task worker: Mailing queue"),
 *   cron = {"time" = 120}
 * )
 */
class MailQueue extends QueueWorkerBase {
  /**
   * {@inheritdoc}
   */
  public function processItem($item) {
    db_insert('mailing')->fields(array('mail' => $item))->execute();
  }
}