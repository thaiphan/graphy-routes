<?php

namespace Drupal\graphy_routes\Wrappers;

use Drupal\Core\Entity\Query\QueryInterface;
use GraphQL\Deferred;

class QueryConnection {

  /**
   * @var \Drupal\Core\Entity\Query\Sql\Query
   */
  protected $query;

  /**
   * QueryConnection constructor.
   *
   * @param \Drupal\Core\Entity\Query\QueryInterface $query
   */
  public function __construct(QueryInterface $query) {
    $this->query = $query;
  }

  /**
   * @return int
   */
  public function total() {
    $query = clone $this->query;
    $query->range(NULL, NULL)->count();
    return $query->execute();
  }

  /**
   * @return array|\GraphQL\Deferred
   */
  public function items() {
    $result = $this->query->execute();
    if (empty($result)) {
      return [];
    }

    /** @var \Drupal\graphql\GraphQL\Buffers\EntityBuffer $buffer */
    $buffer = \Drupal::service('graphql.buffer.entity');
    $callback = $buffer->add($this->query->getEntityTypeId(), array_values($result));
    return new Deferred(function () use ($callback) {
      /** @var \Drupal\node\NodeInterface[] $entities */
      $entities = $callback();

      $response = [];
      foreach ($entities as $entity) {
        $languages = $entity->getTranslationLanguages();

        foreach ($languages as $language) {
          $response[] = $entity->getTranslation($language->getId());
        }
      }

      return $response;
    });
  }
}
