<?php

namespace ImportSystem\Location\Application\SelectList;

class SelectListLocationResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListLocationResponse constructor.
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
