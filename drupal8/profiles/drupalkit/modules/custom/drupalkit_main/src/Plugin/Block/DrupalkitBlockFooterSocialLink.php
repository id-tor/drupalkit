<?php

namespace Drupal\drupalkit_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DrupalkitBlockFooterSocialLink' block.
 *
 * @Block(
 *  id = "drupalkit_block_footer_social_link",
 *  admin_label = @Translation("Drupalkit block footer social link"),
 * )
 */
class DrupalkitBlockFooterSocialLink extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $menu_items = [];

    $menu_items[] = [
      'title' => '',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-twitter',
    ];
    $menu_items[] = [
      'title' => '',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-facebook',
    ];
    $menu_items[] = [
      'title' => '',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-google-plus',
    ];
    $menu_items[] = [
      'title' => '',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-instagram',
    ];
    $menu_items[] = [
      'title' => '',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-linkedin',
    ];
    $menu_items[] = [
      'title' => '',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-rss',
    ];

    \Drupal::currentUser()->id();
    $current_path = \Drupal::service('path.current')->getPath();
    foreach ($menu_items as $key => $item) {
      if (!empty($item['link']) && ($item['link'] == $current_path || ($item['link'] == '/' && $current_path == '<front>'))) {
        $menu_items[$key]['link_active'] = 'active';
        if (isset($item['child'])) {
          foreach ($item['child'] as $key_child => $item_child) {
            $menu_items[$key]['child'][$key_child]['link_active'] = 'active';
          }
        }
      }
    }

    $build = array(
      '#title' => 'Drupalkit: Footer menu social link',
      '#theme' => 'drupalkit_block_footer_social_link',
      '#cache' => ['max-age' => 0],
      '#items' => $menu_items,
    );

    return $build;
  }
}
