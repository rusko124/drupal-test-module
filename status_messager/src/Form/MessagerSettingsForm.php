<?php

namespace Drupal\status_messager\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class MessagerSettingsForm extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'status_messager_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['status_messager.settings'];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('status_messager.settings');

    $form['color'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Color'),
      '#default_value' => $config->get('color'),
    );
    $form['height'] = array(
      '#type' => 'number',
      '#title' => $this->t('Height'),
      '#default_value' => $config->get('height'),
      '#min' => 200,
      '#max' => 600
    );
    $form['width'] = array(
      '#type' => 'number',
      '#title' => $this->t('Width'),
      '#default_value' => $config->get('width'),
      '#min' => 200,
      '#max' => 1000
    );
      return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration
    $this->config('status_messager.settings')
      // Set the submitted configuration setting
      ->set('color', $form_state->getValue('color'))
      ->set('height', $form_state->getValue('height'))
      ->set('width', $form_state->getValue('width'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
