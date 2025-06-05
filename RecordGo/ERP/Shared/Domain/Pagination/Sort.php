<?php


namespace Shared\Domain\Pagination;


class Sort
{
    const ORDER_ASC = 'ASC';
    const ORDER_DESC = 'DESC';
    /**
     * @var string
     */
    private $sort;
    /**
     * @var string
     */
    private $order;

    /**
     * Sort constructor.
     * @param string $sort
     * @param string $order
     */
    public function __construct(string $sort, string $order = self::ORDER_ASC)
    {
        $this->sort = $sort;
        $this->order = $order;
    }

    /**
     * @return string
     */
    public function getSort(): string
    {
        return $this->sort;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }


}
