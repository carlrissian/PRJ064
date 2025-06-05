<?php


namespace Shared\Domain\Pagination;


class Pagination
{
    /**
     * @var int|null
     */
    private $limit;
    /**
     * @var int|null
     */
    private $offset;
    /**
     * @var SortCollection|null
     */
    private $sort;

    /**
     * Pagination constructor.
     * @param int|null $limit
     * @param int|null $offset
     * @param SortCollection|null $sort
     */
    public function __construct(?int $limit = null, ?int $offset = null, ?SortCollection $sort = null)
    {
        $this->limit = $limit;
        $this->offset = $offset;
        $this->sort = $sort;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @return int|null
     */
    public function getOffset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return SortCollection|null
     */
    public function getSort(): ?SortCollection
    {
        return $this->sort;
    }
}