<?php


namespace Shared\Domain\Pagination;


use Shared\Domain\Collection;

class SortCollection extends Collection
{

    /**
     * @return string
     */
    protected function type(): string
    {
        return Sort::class;
    }
}