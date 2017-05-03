<?php
/**
 * @file
 * Contains \Drupal\mailing\Plugin\QueueWorker\MailingQueue.
 */
namespace Drupal\mailing\Plugin\QueueWorker;
use Drupal\Core\Queue\QueueWorkerBase;
/**
 * Processes Tasks for mailing.
 *
 * @QueueWorker(
 *   id = "mailing_queue",
 *   title = @Translation("Mailing task worker: Mailing queue"),
 *   cron = {"time" = 60}
 * )
 */
class MailingQueue extends QueueWorkerBase {
  /**
   * {@inheritdoc}
   */
  public function processItem($item) {
    $config = \Drupal::config('mailing.settings');
    $params = [
      'subject' => $config->get('subject'),
      'body' => $config->get('message'),
    ];
    $mailManager = \Drupal::service('plugin.manager.mail');   
    $mailManager->mail('mailing', 'mailing_queue', $item, 'en', $params , $send = TRUE);
  }
}