<?php

namespace ImportSystem\Acriss\Application\SelectList;

class SelectListAcrissResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListAcrissResponse constructor.
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
