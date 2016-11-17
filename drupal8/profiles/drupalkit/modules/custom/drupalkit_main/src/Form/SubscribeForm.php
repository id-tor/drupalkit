<?php
namespace Drupal\drupalkit_main\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SubscribeForm extends FormBase {

  public function getFormId() {
    return 'drupalkit_subscribe_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['email'] = array(
      '#type' => 'email',
      '#title' => t('Stay up to date with the latest news and offers from Velocity'),
      '#placeholder' => 'Enter your email address',
      '#suffix' => '<div class="email-validation-message"></div>'
    );

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Subscribe Now'),
      '#button_type' => 'primary',
    );

    return $form;
  }

  /**
   * Form submit.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    drupal_set_message($this->t('Thank you @email, You have successfully for subscribing to our newsletter =)', array(
      '@email' => $form_state->getValue('email'),
    )));
  }
}
