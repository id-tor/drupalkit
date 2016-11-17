<?php

namespace Drupal\drupalkit_main\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Drupal module entity.
 *
 * @ConfigEntityType(
 *   id = "drupal_module",
 *   label = @Translation("Drupal module"),
 *   handlers = {
 *     "list_builder" = "Drupal\drupalkit_main\DrupalModuleListBuilder",
 *     "form" = {
 *       "add" = "Drupal\drupalkit_main\Form\DrupalModuleForm",
 *       "edit" = "Drupal\drupalkit_main\Form\DrupalModuleForm",
 *       "delete" = "Drupal\drupalkit_main\Form\DrupalModuleDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\drupalkit_main\DrupalModuleHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "drupal_module",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/drupal_module/{drupal_module}",
 *     "add-form" = "/admin/structure/drupal_module/add",
 *     "edit-form" = "/admin/structure/drupal_module/{drupal_module}/edit",
 *     "delete-form" = "/admin/structure/drupal_module/{drupal_module}/delete",
 *     "collection" = "/admin/structure/drupal_module"
 *   }
 * )
 */
class DrupalModule extends ConfigEntityBase implements DrupalModuleInterface {

  /**
   * The Drupal module ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Drupal module label.
   *
   * @var string
   */
  protected $label;

}
