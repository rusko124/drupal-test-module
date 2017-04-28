<?php
/**
 * @file
 * Contains Drupal/simple_notes/Form/NoteBatchForm.
 */
namespace Drupal\simple_notes\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class NoteBatchForm.
 */
class NoteBatchForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'note_batch_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['start_date'] = array(
      '#type' => 'datetime',
      '#title' => t('Date'),
    );

    $form['status_batch_change'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Set status'),
    );

    $form['status_batch_clear'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Clear status'),
      '#submit' => array([$this,'status_batch_clear_submit']),
      '#limit_validation_errors' => array() ,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    if (!($form_state->getValue('start_date'))) {
      drupal_set_message('Datetime not picked!', 'warning');
      return;
    }

    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'note')
      ->sort('created', 'ASC')
      ->execute();
    $batch = array(
      'title' => t('Change status...'),
      'operations' => array(
        array(
          '\Drupal\simple_notes\StatusChangeNote::statusChangeTo',
          array($nids, $form_state->getValue('start_date'))
        ),
      ),
      'finished' => '\Drupal\simple_notes\StatusChangeNote::statusChangeToFinishedCallback',
    );
    batch_set($batch);
  }

  /**
   *This function for submit status_batch_clear.
   */
  public function status_batch_clear_submit(array &$form, FormStateInterface $form_state){
    $nids = \Drupal::entityQuery('node')
      ->condition('type', 'note')
      ->sort('created', 'ASC')
      ->execute();
    $batch = array(
      'title' => t('Change status...'),
      'operations' => array(
        array(
          '\Drupal\simple_notes\StatusChangeNote::statusChangeToNull',
          array($nids)
        ),
      ),
      'finished' => '\Drupal\simple_notes\StatusChangeNote::statusChangeToNullFinishedCallback',
    );
    batch_set($batch);
  }

}
