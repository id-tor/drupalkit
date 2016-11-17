<?php

/**
 * @file
 * Contains ingot.page.inc.
 *
 * Page callback for Ingot entities.
 */

use Drupal\Core\Render\Element;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Prepares variables for Ingot templates.
 *
 * Default template: ingot.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_ingot(array &$variables) {
  // Fetch Ingot Entity Object.
  $ingot = $variables['elements']['#ingot'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
