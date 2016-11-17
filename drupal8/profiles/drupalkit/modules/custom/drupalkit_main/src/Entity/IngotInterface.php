<?php

namespace Drupal\drupalkit_main\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Ingot entities.
 *
 * @ingroup drupalkit_main
 */
interface IngotInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Ingot name.
   *
   * @return string
   *   Name of the Ingot.
   */
  public function getName();

  /**
   * Sets the Ingot name.
   *
   * @param string $name
   *   The Ingot name.
   *
   * @return \Drupal\drupalkit_main\Entity\IngotInterface
   *   The called Ingot entity.
   */
  public function setName($name);

  /**
   * Gets the Ingot creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Ingot.
   */
  public function getCreatedTime();

  /**
   * Sets the Ingot creation timestamp.
   *
   * @param int $timestamp
   *   The Ingot creation timestamp.
   *
   * @return \Drupal\drupalkit_main\Entity\IngotInterface
   *   The called Ingot entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Ingot published status indicator.
   *
   * Unpublished Ingot are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Ingot is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Ingot.
   *
   * @param bool $published
   *   TRUE to set this Ingot to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\drupalkit_main\Entity\IngotInterface
   *   The called Ingot entity.
   */
  public function setPublished($published);

}
