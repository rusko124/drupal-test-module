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
   *Ajax message about user login or not
   *
   * Callback for user_login_form
   *
   * @param array $form
   * @param FormStateInterface $form_state
   * @return AjaxResponse
   */


  public function ajaxSubmitCallback(array &$form, FormStateInterface $form_state) {

    $ajax_response = new AjaxResponse();

    $auth = \Drupal::currentUser()->isAuthenticated();

    if ($auth == true) {
      $ajax_response->addCommand(new HtmlCommand('#' . Html::getClass($form['form_id']['#value']) . '-messages',
      t('Hello @name! To see the website as a registered user go to <a href="@link">this link</a>.',
        ['@name' => $form_state->getValue('name'),
          '@link' => '/']))
      );

      $ajax_response->addCommand(new CssCommand('.form-item-name', ['display' => 'none']));
      $ajax_response->addCommand(new CssCommand('.form-item-pass', ['display' => 'none']));
      $ajax_response->addCommand(new CssCommand('#edit-actions', ['display' => 'none']));
    }
    else {
      $ajax_response->addCommand(new HtmlCommand('#' . Html::getClass($form['form_id']['#value']) . '-messages',
        t(' Incorrect login and/or password!')));
    };
    return $ajax_response;
  }
}
