<?php

namespace ImportSystem\PurchaseType\Application\SelectList;

class SelectListPurchaseTypeResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListPurchaseTypeResponse constructor.
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
