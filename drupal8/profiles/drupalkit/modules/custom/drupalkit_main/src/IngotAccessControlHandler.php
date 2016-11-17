<?php

namespace Drupal\drupalkit_main;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Ingot entity.
 *
 * @see \Drupal\drupalkit_main\Entity\Ingot.
 */
class IngotAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\drupalkit_main\Entity\IngotInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished ingot entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published ingot entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit ingot entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete ingot entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add ingot entities');
  }

}
