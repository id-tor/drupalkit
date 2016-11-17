<?php

namespace Drupal\drupalkit_main\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Ingot entities.
 */
class IngotViewsData extends EntityViewsData implements EntityViewsDataInterface {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['ingot']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Ingot'),
      'help' => $this->t('The Ingot ID.'),
    );

    return $data;
  }

}
