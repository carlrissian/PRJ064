<?php

namespace ImportSystem\MotorizationType\Application\SelectList;

class SelectListMotorizationTypeResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListMotorizationTypeResponse constructor.
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
