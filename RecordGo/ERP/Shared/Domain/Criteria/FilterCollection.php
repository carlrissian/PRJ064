<?php


namespace Shared\Domain\Criteria;


use Shared\Domain\Collection;

/**
 * Class FilterCollection
 * @package Shared\Domain\Criteria
 * @method Filter[] getIterator()
 */
class FilterCollection extends Collection
{

    /**
     * @var Filter[]
     */
    protected $items;

    /**
     * @return string
     */
    protected function type(): string
    {
        return Filter::class;
    }

    public function findByField(string $field): ?Filter
    {
        foreach ($this->items as $filter) {
            if ($filter->getField() === $field) {
                return $filter;
            }
        }
        return null;
    }
}