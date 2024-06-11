<?php

namespace Drupal\d10test_facets_pretty_paths;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Alter facet source routes, adding a parameter.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  public function alterRoutes(RouteCollection $collection) {
    try {
      $sourceRoute = $collection->get('entity.taxonomy_term.canonical');
      if ($sourceRoute && strpos($sourceRoute->getPath(), '/{facets_query}') === FALSE) {
        $sourceRoute->setPath($sourceRoute->getPath() . '/{facets_query}');
        $sourceRoute->setDefault('facets_query', '');
        $sourceRoute->setRequirement('facets_query', '[^\d]{1}.*');
        $routePath = $sourceRoute->getPath();

        for ($i = 0; strlen($routePath) < 250; $i++) {
          $sourceRoute->setDefault('f' . $i, '');
          $routePath .= "/{f{$i}}";
        }

        $sourceRoute->setPath($routePath);
      }
    }
    catch (\Exception $e) {
    }
  }

}
