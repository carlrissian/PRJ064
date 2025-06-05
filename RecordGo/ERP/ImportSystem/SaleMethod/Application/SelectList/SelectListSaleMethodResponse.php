<?php

namespace ImportSystem\SaleMethod\Application\SelectList;

class SelectListSaleMethodResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListSaleMethodResponse constructor.
     *
     * @param array $selectList
     */
    public function __construct(array $selectList)
    {
        $this->selectList = $selectList;
    }

    /**
     * @return array
     */
    public function getSelectList(): array
    {
        return $this->selectList;
    }
}
