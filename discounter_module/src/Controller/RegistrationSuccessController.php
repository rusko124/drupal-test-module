<?php
/**
 * @file
 * Contains \Drupal\discounter_module\Controller\RegistrationSuccessController.
 */
namespace Drupal\discounter_module\Controller;

use Drupal\Core\Controller\ControllerBase;

class RegistrationSuccessController extends ControllerBase {

  public function welcome() {
    //Load settings
    $settings = \Drupal::config('discounter_module.settings');
    //Load user id
    $user_id = \Drupal::currentUser()->id();
   //GET CODE DISCOUNT
    $array = entity_load_multiple('discount_entity');
    foreach ($array as $key => $value) {
      if ($user_id == $value->field_user->target_id) {
        $account = \Drupal\user\Entity\User::load($user_id);
        $user = $account->get('name')->value;
        $code = $value->field_discount_code->value;
      }
    }
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
