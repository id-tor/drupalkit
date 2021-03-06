<?php

/**
 * @file
 * Contains \Drupal\field_validation\Form\FieldValidationRuleSetEditForm.
 */

namespace Drupal\field_validation\Form;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\field_validation\ConfigurableFieldValidationRuleInterface;
use Drupal\field_validation\FieldValidationRuleManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for blocktabs edit form.
 */
class FieldValidationRuleSetEditForm extends FieldValidationRuleSetFormBase {

  /**
   * The fieldValidationRule manager service.
   *
   * @var \Drupal\field_validation\FieldValidationRuleManager
   */
  protected $fieldValidationRuleManager;

  /**
   * Constructs an FieldValidationRuleSetEditForm object.
   *
   * @param \Drupal\Core\Entity\EntityStorageInterface $entity_storage
   *   The storage.
   * @param \Drupal\field_validation\FieldValidationRuleManager $field_validation_rule_manager
   *   The field_validation_rule manager service.
   */
  public function __construct(EntityStorageInterface $entity_storage, FieldValidationRuleManager $field_validation_rule_manager) {
    parent::__construct($entity_storage);
    $this->fieldValidationRuleManager = $field_validation_rule_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity.manager')->getStorage('field_validation_rule_set'),
      $container->get('plugin.manager.field_validation.field_validation_rule')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $user_input = $form_state->getUserInput();
    $form['#title'] = $this->t('Edit field validation rule set %name', array('%name' => $this->entity->label()));
    $form['#tree'] = TRUE;
    //$form['#attached']['library'][] = 'field_validation/admin';


    // Build the list of existing field validation rule for this rule set.
    $form['rules'] = array(
      '#type' => 'table',
      '#header' => array(
        $this->t('Rule'),
        $this->t('Weight'),
        $this->t('Operations'),
      ),
      '#tabledrag' => array(
        array(
          'action' => 'order',
          'relationship' => 'sibling',
          'group' => 'rule-order-weight',
        ),
      ),
      '#attributes' => array(
        'id' => 'field-validation-rule-set-rules',
      ),
      '#empty' => t('There are currently no rules in this rule set. Add one by selecting an option below.'),
      // Render tabs below parent elements.
      '#weight' => 5,
    );
	$field_validation_rules =  $this->entity->getFieldValidationRules();
	//drupal_set_message(var_export($field_validation_rules, true));
    foreach ($field_validation_rules as $field_validation_rule) {
	  //drupal_set_message('abcd');
      $key = $field_validation_rule->getUuid();
      $form['rules'][$key]['#attributes']['class'][] = 'draggable';
      $form['rules'][$key]['#weight'] = isset($user_input['rules']) ? $user_input['rules'][$key]['weight'] : NULL;
      $form['rules'][$key]['rule'] = array(
        '#tree' => FALSE,
        'data' => array(
          'label' => array(
            '#plain_text' => $field_validation_rule->label(),
          ),
        ),
      );

      $summary = $field_validation_rule->getSummary();

      if (!empty($summary)) {
        $summary['#prefix'] = ' ';
        $form['rules'][$key]['rule']['data']['summary'] = $summary;
      }

      $form['rules'][$key]['weight'] = array(
        '#type' => 'weight',
        '#title' => $this->t('Weight for @title', array('@title' => $field_validation_rule->label())),
        '#title_display' => 'invisible',
        '#default_value' => $field_validation_rule->getWeight(),
        '#attributes' => array(
          'class' => array('rule-order-weight'),
        ),
      );

      $links = array();
      $is_configurable = $field_validation_rule instanceof ConfigurableFieldValidationRuleInterface;
      if ($is_configurable) {
        $links['edit'] = array(
          'title' => $this->t('Edit'),
          'url' => Url::fromRoute('field_validation.field_validation_rule_edit_form', [
            'field_validation_rule_set' => $this->entity->id(),
            'field_validation_rule' => $key,
          ]),
        );
      }
      $links['delete'] = array(
        'title' => $this->t('Delete'),
        'url' => Url::fromRoute('field_validation.field_validation_rule_delete', [
          'field_validation_rule_set' => $this->entity->id(),
          'field_validation_rule' => $key,
        ]),
      );
      $form['rules'][$key]['operations'] = array(
        '#type' => 'operations',
        '#links' => $links,
      );
    }

    // Build the new field_validation_rule addition form and add it to the field_validation_rule list.
    $new_field_validation_rule_options = array();
    $field_validation_rules = $this->fieldValidationRuleManager->getDefinitions();
	//drupal_set_message(var_export($field_validation_rules, true));
    uasort($field_validation_rules, function ($a, $b) {
      return strcasecmp($a['id'], $b['id']);
    });
    foreach ($field_validation_rules as $field_validation_rule => $definition) {
      $new_field_validation_rule_options[$field_validation_rule] = $definition['label'];
    }
    $form['rules']['new'] = array(
      '#tree' => FALSE,
      '#weight' => isset($user_input['weight']) ? $user_input['weight'] : NULL,
      '#attributes' => array('class' => array('draggable')),
    );
    $form['rules']['new']['rule'] = array(
      'data' => array(
        'new' => array(
          '#type' => 'select',
          '#title' => $this->t('Rule'),
          '#title_display' => 'invisible',
          '#options' => $new_field_validation_rule_options,
          '#empty_option' => $this->t('Select a new rule'),
        ),
        array(
          'add' => array(
            '#type' => 'submit',
            '#value' => $this->t('Add'),
            '#validate' => array('::fieldValidationRuleValidate'),
            '#submit' => array('::submitForm', '::fieldValidationRuleSave'),
          ),
        ),
      ),
      '#prefix' => '<div class="field-validation-rule-new">',
      '#suffix' => '</div>',
    );

    $form['rules']['new']['weight'] = array(
      '#type' => 'weight',
      '#title' => $this->t('Weight for new rule'),
      '#title_display' => 'invisible',
      '#default_value' => count($this->entity->getFieldValidationRules()) + 1,
      '#attributes' => array('class' => array('rule-order-weight')),
    );
    $form['rules']['new']['operations'] = array(
      'data' => array(),
    );

    return parent::form($form, $form_state);
  }

  /**
   * Validate handler for fieldValidationRule.
   */
  public function fieldValidationRuleValidate($form, FormStateInterface $form_state) {
    if (!$form_state->getValue('new')) {
      $form_state->setErrorByName('new', $this->t('Select an rule to add.'));
    }
  }

  /**
   * Submit handler for fieldValidationRule.
   */
  public function fieldValidationRuleSave($form, FormStateInterface $form_state) {
    $this->save($form, $form_state);

    // Check if this field has any configuration options.
    $field_validation_rule = $this->fieldValidationRuleManager->getDefinition($form_state->getValue('new'));

    // Load the configuration form for this option.
    if (is_subclass_of($field_validation_rule['class'], '\Drupal\field_validation\ConfigurableFieldValidationRuleInterface')) {
      $form_state->setRedirect(
        'field_validation.field_validation_rule_add_form',
        array(
          'field_validation_rule_set' => $this->entity->id(),
          'field_validation_rule' => $form_state->getValue('new'),
        ),
        array('query' => array('weight' => $form_state->getValue('weight')))
      );
    }
    // If there's no form, immediately add the rule.
    else {
      $field_validation_rule = array(
        'id' => $field_validation_rule['id'],
        'data' => array(),
        'weight' => $form_state->getValue('weight'),
      );
      $field_validation_rule_id = $this->entity->addFieldValidationRule($field_validation_rule);
      $this->entity->save();
      if (!empty($tab_id)) {
        drupal_set_message($this->t('The rule was successfully added.'));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Update tab weights.
    if (!$form_state->isValueEmpty('rules')) {
      $this->updateFieldValidationRuleWeights($form_state->getValue('rules'));
    }

    parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    drupal_set_message($this->t('Changes to the field validation rule set have been saved.'));
  }

  /**
   * {@inheritdoc}
   */
  public function actions(array $form, FormStateInterface $form_state) {
    $actions = parent::actions($form, $form_state);
    $actions['submit']['#value'] = $this->t('Update field validation rule set');

    return $actions;
  }

  /**
   * Updates fieldValidationRule weights.
   *
   * @param array $field_validation_rules
   *   Associative array with tabs having fieldValidationRule uuid as keys and array
   *   with fieldValidationRule data as values.
   */
  protected function updateFieldValidationRuleWeights(array $field_validation_rules) {
    foreach ($field_validation_rules as $uuid => $field_validation_rule_data) {
      if ($this->entity->getFieldValidationRules()->has($uuid)) {
        $this->entity->getFieldValidationRule($uuid)->setWeight($field_validation_rule_data['weight']);
      }
    }
  }

}
