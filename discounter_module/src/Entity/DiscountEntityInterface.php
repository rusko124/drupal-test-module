<?php

namespace Drupal\discounter_module\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Discount entity entities.
 *
 * @ingroup discounter_module
 */
interface DiscountEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Discount entity name.
   *
   * @return string
   *   Name of the Discount entity.
   */
  public function getName();

  /**
   * Sets the Discount entity name.
   *
   * @param string $name
   *   The Discount entity name.
   *
   * @return \Drupal\discounter_module\Entity\DiscountEntityInterface
   *   The called Discount entity entity.
   */
  public function setName($name);

  /**
   * Gets the Discount entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Discount entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Discount entity creation timestamp.
   *
   * @param int $timestamp
   *   The Discount entity creation timestamp.
   *
   * @return \Drupal\discounter_module\Entity\DiscountEntityInterface
   *   The called Discount entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Discount entity published status indicator.
   *
   * Unpublished Discount entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Discount entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Discount entity.
   *
   * @param bool $published
   *   TRUE to set this Discount entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\discounter_module\Entity\DiscountEntityInterface
   *   The called Discount entity entity.
   */
  public function setPublished($published);

}
