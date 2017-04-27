<?php

/**
 * @file
 * Contains discount_entity.page.inc.
 *
 * Page callback for Discount entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Discount entity templates.
 *
 * Default template: discount_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_discount_entity(array &$variables) {
  // Fetch DiscountEntity Entity Object.
  $discount_entity = $variables['elements']['#discount_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
