<?php
/**
 * @file
 * Contains \Drupal\Learning\Form\MailingQueueForm.
 */
namespace Drupal\mailing\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Contribute form.
 */
class MailingQueueForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
     return 'mailing_form';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['mailing.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('mailing.settings');

    $form['subject'] = array(
      '#type' => 'textfield',
      '#title' => t('Subject'),
      '#required' => TRUE,
      '#default_value' => ($config->get('subject')),
    );
    $form['message'] = array(
      '#type' => 'textarea',
      '#title' => t('Message'),
      '#required' => TRUE,
      '#default_value' => ($config->get('message')),
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => t('Submit'),
    );
    $form['clear_db_mailing'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Clear e-mails was send'),
      '#submit' => array([$this,'clear_db_mailing_submit']),
      '#limit_validation_errors' => array() ,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('mailing.settings')
      ->set('subject', $form_state->getValue('subject'))
      ->set('message', $form_state->getValue('message'))
      ->save();
    drupal_set_message('Settings saved.');
  }

  public function clear_db_mailing_submit() {
    db_query('UPDATE mailing SET send = 0');
    drupal_set_message('All mails sended was clear.');
  }
}
