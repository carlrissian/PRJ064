<?php

namespace ImportSystem\GearBox\Application\SelectList;

class SelectListGearBoxResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListGearBoxResponse constructor.
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
