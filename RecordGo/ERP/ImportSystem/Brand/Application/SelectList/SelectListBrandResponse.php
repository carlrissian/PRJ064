<?php

namespace ImportSystem\Brand\Application\SelectList;

class SelectListBrandResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListBrandResponse constructor.
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
