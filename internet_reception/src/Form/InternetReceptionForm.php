<?php
/**
 * @file
 * Contains \Drupal\internet_reception\Form\InternetReceptionForm.
 *
 */

namespace Drupal\internet_reception\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class InternetReceptionForm extends FormBase {
  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'internet_reception_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = ['#type' => 'textfield',
      '#title' => $this->t('Your name'),
      '#required' => true,
    ];

    $form['email'] = ['#type' => 'email',
      '#title' => $this->t('Your email'),
      '#required' => true,
    ];

    $form['age'] = ['#type' => 'number',
      '#title' => $this->t('Your age'),
      '#required' => true,
      '#min' => 0,
      '#max' => 150,
    ];

    $form['subject'] = ['#type' => 'textfield',
      '#title' => $this->t("Subject"),
      '#required' => true,
    ];

    $form['message'] = ['#type' => 'textarea',
      '#title' => $this->t('Message'),
      '#required' => true,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = ['#type' => 'submit',
      '#value' => $this->t('Send message'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

    if (strlen($form_state->getValue('name')) < 5) {
      $form_state->setErrorByName('name', $this->t('Name is too short.'));
    };
  }

  /**
   * {@inheritdoc}.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Thank you @name!', ['@name' => $form_state->getValue('name'),]));

    $mailManager = \Drupal::service('plugin.manager.mail');
    $params = [
      'subject' => $form_state->getValue('subject'),
      'body' => 'Message: ' . $form_state->getValue('message'),
    ];
    $key = 'internet_reception_key';
    $to = \Drupal::config('system.site')->get('mail');
    $from = $form_state->getValue('email');
    $mailManager->mail('internet_reception', $key, $to, \Drupal::currentUser()->getPreferredLangcode(), $params, $from, true);
  }
};
