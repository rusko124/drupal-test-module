<?php

namespace Drupal\mailing\Controller;
use Drupal\Core\Controller\ControllerBase;

class Test extends ControllerBase {
  public function test() {
    $output = array();
	// $queue_mail = \Drupal::queue('mail');
	// $item = $queue_mail->claimItem();
	// print_r($item->data['username']);
	// print_r($item->data['mail']);

	$mail = ['1' => 'hi', '2' => 'bye'];
	print_r($mail);

    return $output;
  }
}
