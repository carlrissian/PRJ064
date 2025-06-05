<?php

namespace ImportSystem\CarGroup\Application\SelectList;

class SelectListCarGroupResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListCarGroupResponse constructor.
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
