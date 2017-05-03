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
  public function processItem($array) {
    $config = \Drupal::config('mailing.settings');

    $token = \Drupal::token();
    $admin_mail = \Drupal::config('system.site')->get('mail');;  
    $data = array('mailing_admin_mail' => $admin_mail, 'mailing_user' => $array['username']);
    $message = $config->get('message');   
    $message = $token->replace($message, $data);

    $params = [
      'subject' => $config->get('subject'),
      'body' => $message,
    ];
    
    $mailManager = \Drupal::service('plugin.manager.mail');   
    $mailManager->mail('mailing', 'mailing_queue', $array['mail'], 'en', $params , $send = TRUE);
  }
}
