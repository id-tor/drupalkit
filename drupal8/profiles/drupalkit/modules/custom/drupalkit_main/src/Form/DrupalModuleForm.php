<?php

namespace Drupal\drupalkit_main\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class DrupalModuleForm.
 *
 * @package Drupal\drupalkit_main\Form
 */
class DrupalModuleForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $drupal_module = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $drupal_module->label(),
      '#description' => $this->t("Label for the Drupal module."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $drupal_module->id(),
      '#machine_name' => [
        'exists' => '\Drupal\drupalkit_main\Entity\DrupalModule::load',
      ],
      '#disabled' => !$drupal_module->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $drupal_module = $this->entity;
    $status = $drupal_module->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Drupal module.', [
          '%label' => $drupal_module->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Drupal module.', [
          '%label' => $drupal_module->label(),
        ]));
    }
    $form_state->setRedirectUrl($drupal_module->urlInfo('collection'));
  }

}
