<?php
/**
 * @file
 * Contains \Drupal\services\Plugin\ServiceDefinition\NodeGet.php
 */

namespace Drupal\services\Plugin\ServiceDefinition;


use Drupal\Component\Serialization\SerializationInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\services\ServiceDefinitionBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * @ServiceDefinition(
 *   id = "node_get",
 *   title = @Translation("Node: Retrieve"),
 *   description = @Translation("Retrieves a node object and serializes it as a response to the current request."),
 *   path = "node/{node}",
 *   translatable = true,
 *   category = @Translation("Node"),
 *   context = {
 *     "node" = @ContextDefinition("entity:node", label = @Translation("Node"))
 *   }
 * )
 *
 */
class NodeGet extends ServiceDefinitionBase {

  /**
   * {@inheritdoc}
   */
  public function processRequest(Request $request, RouteMatchInterface $route_match) {
    $node = $this->getContext('node');

  }

}