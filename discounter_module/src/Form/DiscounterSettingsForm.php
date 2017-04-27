<?php
/**
 *This form settings discounter module.
 */

namespace Drupal\discounter_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class DiscounterSettingsForm extends ConfigFormBase {
  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'discounter_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['discounter_module.settings'];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('discounter_module.settings');

    $form['welcome_message'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Welcome message'),
      '#default_value' => ($config->get('welcome_message')),
      '#description' => t('Use like this: [discounter:username] for username, [discounter:discount_code] for discount code.'),
    );

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    
    $this->config('discounter_module.settings')
      ->set('welcome_message', $form_state->getValue('welcome_message'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
