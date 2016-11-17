<?php

namespace Drupal\drupalkit_main\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'DrupalkitBlockFooterMenu' block.
 * @Block(
 *  id = "drupalkit_block_footer_menu",
 *  admin_label = @Translation("Drupalkit block footer menu"),
 * )
 */
class DrupalkitBlockFooterMenu extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $menu_items = [];

    $menu_items['first-col'] = [];
    $menu_items['first-col']['title'] = [
      'title' => 'About us',
      'icon' => '',
      'class' => '',
    ];
    $menu_items['first-col'][] = [
      'title' => 'Who we are?',
      'link' => '/one',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['first-col'][] = [
      'title' => 'Press',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['first-col'][] = [
      'title' => 'Blog',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['first-col'][] = [
      'title' => 'Jobs',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['first-col'][] = [
      'title' => 'Contact us',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];

    $menu_items['second-col'] = [];
    $menu_items['second-col']['title'] = [
      'title' => 'Product',
      'icon' => '',
      'class' => '',
    ];
    $menu_items['second-col'][] = [
      'title' => 'How it works?',
      'link' => '/two',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['second-col'][] = [
      'title' => 'API',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['second-col'][] = [
      'title' => 'Download Apps',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['second-col'][] = [
      'title' => 'Pricing',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];

    $menu_items['third-col'] = [];
    $menu_items['third-col']['title'] = [
      'title' => 'Support',
      'icon' => '',
      'class' => '',
    ];
    $menu_items['third-col'][] = [
      'title' => 'Help',
      'link' => '/three',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['third-col'][] = [
      'title' => 'Documentation',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['third-col'][] = [
      'title' => 'Terms of service',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];
    $menu_items['third-col'][] = [
      'title' => 'Privacy',
      'link' => '/',
      'icon' => '',
      'class' => 'fa fa-caret-right',
    ];

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

    $build = [
      '#title' => 'Drupalkit: Footer menu',
      '#theme' => 'drupalkit_block_footer_menu',
      '#cache' => ['max-age' => 0],
      '#items' => $menu_items,
    ];

    return $build;
  }
}
