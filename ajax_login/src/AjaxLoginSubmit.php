<?php

/**
 * @file
 * Contains \Drupal\ajax_login\AjaxLoginSubmit.
 */

namespace Drupal\ajax_login;

use Drupal\Component\Utility\Html;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\CssCommand;
use Drupal\Core\Form\FormStateInterface;


class AjaxLoginSubmit {

 /**
  * {@inheritdoc}.
  */
  public function ajaxSubmitCallback(array &$form, FormStateInterface $form_state) {

    $ajax_response = new AjaxResponse();

    $auth = \Drupal::currentUser()->isAuthenticated();

    $link_to_title = "<br><a href='/'>DRUPAL LINK </a>";

    if ($auth == true) {
      $ajax_response->addCommand(new HtmlCommand('#' . Html::getClass($form['form_id']['#value']) . '-messages',
        ' Hello, '.$form_state->getValue('name').'! To see the website as a registered user go to this link.' . $link_to_title)
      );
      $ajax_response->addCommand(new CssCommand('.form-item-name', ['display' => 'none']));
      $ajax_response->addCommand(new CssCommand('.form-item-pass', ['display' => 'none']));
      $ajax_response->addCommand(new CssCommand('#edit-actions', ['display' => 'none']));
    } else {
      $ajax_response->addCommand(new HtmlCommand('#' . Html::getClass($form['form_id']['#value']) . '-messages', " Incorrect login and/or password!"));
    };
    return $ajax_response;
  }
}
