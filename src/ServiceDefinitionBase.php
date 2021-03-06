<?php
/**
 * @file
 * Provides Drupal\services\ServiceDefinitionBase.
 */

namespace Drupal\services;


use Drupal\Component\Plugin\Context\ContextInterface as ComponentContextInterface;
use Drupal\Core\Plugin\ContextAwarePluginBase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Route;

abstract class ServiceDefinitionBase extends ContextAwarePluginBase implements ServiceDefinitionInterface {

  /**
   * {@inheritdoc}
   */
  public function getTitle() {
    return $this->pluginDefinition['title'];
  }

  /**
   * {@inheritdoc}
   */
  public function getCategory() {
    return $this->pluginDefinition['category'];
  }

  /**
   * {@inheritdoc}
   */
  public function getPath() {
    return $this->pluginDefinition['path'];
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  /**
   * {@inheritdoc}
   */
  public function supportsTranslation() {
    return $this->pluginDefinition['translatable'];
  }

  /**
   * {@inheritdoc}
   */
  public function getArguments() {
    return $this->pluginDefinition['arguments'];
  }

  /**
   * {@inheritdoc}
   */
  public function processRoute(Route $route) {
    $route->addRequirements(array('_access' => 'TRUE'));
  }

  /**
   * {@inheritdoc}
   */
  public function processResponse(Response $response) {}

  /**
   * Core plugins do not validate contexts when they are set, but we do.
   *
   * @todo get the other context setter methods covered with validations.
   */
  public function setContext($name, ComponentContextInterface $context) {
    $violations = $context->validate();
    if ($violations->count()) {
      $message = $violations->get(0);
      throw new HttpException(403, (string) $message->getMessage());
    }
    parent::setContext($name, $context);
  }


}
