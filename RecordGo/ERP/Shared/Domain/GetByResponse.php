<?php


namespace Shared\Domain;

abstract class GetByResponse
{
    /**
     * @var Collection
     */
    protected $collection;
    /**
     * @var int
     */
    protected $totalRows;

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        return $this->collection;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }

    public function toArray() {
        return [$this->collection, $this->totalRows];
    }
}