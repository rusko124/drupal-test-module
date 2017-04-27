<?php

namespace Drupal\discounter_module;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Discount entity entity.
 *
 * @see \Drupal\discounter_module\Entity\DiscountEntity.
 */
class DiscountEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\discounter_module\Entity\DiscountEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished discount entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published discount entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit discount entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete discount entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add discount entity entities');
  }

}
