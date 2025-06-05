<?php

namespace ImportSystem\Model\Domain;

/**
 * Interface ModelRepository
 * @package Distribution\Model\Domain
 */
interface ModelRepository
{
    /**
     * @param ModelCriteria $criteria
     * @return ModelGetByResponse
     */
    public function getBy(ModelCriteria $criteria): ModelGetByResponse;

    /**
     * @param integer $id
     * @return Model|null
     */
    // public function getById(int $id): ?Model;
}
