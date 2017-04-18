<?php
/**
 * @file
 * Contains \Drupal\internet_reception\Form\MyForm.
 *
 */

namespace Drupal\internet_reception\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MyForm extends FormBase
{

    public function getFormId()
    {
        return 'internet_reception_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {

        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Your name'),
        );

        $form['email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Your email'),
        );

        $form['age'] = array(
            '#type' => 'number',
            '#title' => $this->t('Your age'),
        );

        $form['subject'] = array(
            '#type' => 'textfield',
            '#title' => $this->t("Subject"),
        );

        $form['message'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Message'),
        );

        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Send message'),
            '#button_type' => 'primary',
        );

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        if (strlen($form_state->getValue('name')) < 5) {
            $form_state->setErrorByName('name', $this->t('Name is too short.'));
        }

        if (strlen($form_state->getValue('email')) <= 0) {
            $form_state->setErrorByName('email', $this->t('Email field is empty!'));
        }

        if ($form_state->getValue('age') <= 0 || $form_state->getValue('age') >= 150) {
            $form_state->setErrorByName('age', $this->t('Age is wrong!'));
        }

        if (strlen($form_state->getValue('subject')) <= 0) {
            $form_state->setErrorByName('subject', $this->t('Subject field is empty!'));
        }

        if (strlen($form_state->getValue('message')) <= 0) {
            $form_state->setErrorByName('message', $this->t('Message field is empty!'));
        }
    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        drupal_set_message($this->t('Thank you @name!', array(
            '@name' => $form_state->getValue('name'),
        )));

        $mailManager = \Drupal::service('plugin.manager.mail');
        $params = array('body' => 'Message: ' . $form_state->getValue('message'),);
        $key = 'test_email';
        $to = 'pavel.lvl@yandex.ru';
        $from = $form_state->getValue('email');
        $mailManager->mail('internet_reception', $key, $to, \Drupal::currentUser()->getPreferredLangcode(), $params, $from, true);
    }

}
