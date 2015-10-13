<?php
/**
 * @file
 * Contains \Drupal\services\Plugin\Deriver\EntityGet.php
 */

namespace Drupal\services\Plugin\Deriver;


use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Drupal\ctools\Plugin\Deriver\EntityDeriverBase;

class EntityGet extends EntityDeriverBase {

  public function getDerivativeDefinitions($base_plugin_definition) {
    foreach ($this->entityManager->getDefinitions() as $entity_type_id => $entity_type) {
      $bundle_type = $entity_type->getBundleEntityType();
      if ($bundle_type) {
        $bundle_type = $this->entityManager->getDefinition($bundle_type);
        $bundles = $this->entityManager->getStorage($bundle_type->id())->loadMultiple();
        foreach ($bundles as $bundle) {
          $this->derivativeDefinition($base_plugin_definition, $entity_type_id, $entity_type, $bundle_type, $bundle);
        }
      }
      else {
        $this->derivativeDefinition($base_plugin_definition, $entity_type_id, $entity_type);
      }
    }
    return $this->derivatives;
  }

  protected function derivativeDefinition($base_plugin_definition, $entity_type_id, EntityTypeInterface $entity_type, EntityTypeInterface $bundle_type = NULL, EntityInterface $bundle = NULL) {
    if ($bundle_type && $bundle) {
      $entity_type_id = "$entity_type_id:{$bundle->id()}";
      $this->derivatives[$entity_type_id] = $base_plugin_definition;
      $this->derivatives[$entity_type_id]['title'] = $this->t('@bundle @label: Retrieve', ['@bundle' => $bundle->label(), '@label' => $entity_type->getLabel()]);
      $this->derivatives[$entity_type_id]['description'] = $this->t('Retrieves a @label object of the @bundle_label @bundle and serializes it as a response to the current request.', ['@label' => $entity_type->getLabel(), '@bundle_label' => $bundle_type->getLabel(), '@bundle' => $bundle_type->id()]);
      $this->derivatives[$entity_type_id]['category'] = $this->t('@label', ['@label' => $entity_type->getLabel()]);
      $this->derivatives[$entity_type_id]['path'] = "{$entity_type->id()}/{$bundle->id()}/{entity}";
      $this->derivatives[$entity_type_id]['context'] = [
        'entity' => new ContextDefinition("entity:$entity_type_id", $this->t('@label', ['@label' => "{$bundle->label()} {$entity_type->getLabel()}"]))
      ];
    }
    else {
      $this->derivatives[$entity_type_id] = $base_plugin_definition;
      $this->derivatives[$entity_type_id]['title'] = $this->t('@label: Retrieve', ['@label' => $entity_type->getLabel()]);
      $this->derivatives[$entity_type_id]['description'] = $this->t('Retrieves a @entity_type_id object and serializes it as a response to the current request.', ['@entity_type_id' => $entity_type_id]);
      $this->derivatives[$entity_type_id]['category'] = $this->t('@label', ['@label' => $entity_type->getLabel()]);
      $this->derivatives[$entity_type_id]['path'] = "$entity_type_id/{entity}";
      $this->derivatives[$entity_type_id]['context'] = [
        'entity' => new ContextDefinition("entity:$entity_type_id", $this->t('@label', ['@label' => $entity_type->getLabel()]))
      ];
    }
  }

}
