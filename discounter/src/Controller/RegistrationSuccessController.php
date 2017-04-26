<?php
/**
 * @file
 * Contains \Drupal\discounter\Controller\RegistrationSuccessController.
 */
namespace Drupal\discounter\Controller;

use Drupal\Core\Controller\ControllerBase;

class RegistrationSuccessController extends ControllerBase {

  public function welcome() {
    //Load settings
    $settings = \Drupal::config('discounter.settings');
    //Load user id
    $user_id = \Drupal::currentUser()->id();
    //GET CODE DISCOUNT
    $storage = \Drupal::entityManager()->getStorage('discounter1');
    $query = $storage->getQuery()->range(0, 1);
    $query->Condition('uid', $user_id);
    $query_done = $query->execute();
    if (!($query_done)) {
      $code = '-';
    }
    else {
      $result = array_values($query_done)[0];       
      $code = \Drupal\discounter\Entity\Discounter::load($result)->get('code')->value;
    }
    //GET USERNAME
   $account = \Drupal\user\Entity\User::load($user_id);
   $user = $account->get('name')->value;
    //USE CUSTOM TOKENS
    $token = \Drupal::token();
    $data = array('discounter_code' => $code, 'discounter_user' => $user);
    $message_html = $settings->get('welcome_message');   
    $message_html = $token->replace($message_html, $data);

    $output = array();
    $output['#title'] = $message_html;
    return $output;
  }
}
