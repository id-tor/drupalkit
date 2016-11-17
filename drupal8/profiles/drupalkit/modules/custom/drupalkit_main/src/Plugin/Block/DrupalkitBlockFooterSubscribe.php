<?php

namespace Drupal\drupalkit_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DrupalkitBlockFooterSubscribe' block.
 *
 * @Block(
 *   id = "drupalkit_block_footer_subscribe",
 *   admin_label = @Translation("Drupalkit block footer subscribe"),
 * )
 */
class DrupalkitBlockFooterSubscribe extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $subscribe_form = \Drupal::formBuilder()->getForm('Drupal\drupalkit_main\Form\SubscribeForm');
    return $subscribe_form;
  }
}
