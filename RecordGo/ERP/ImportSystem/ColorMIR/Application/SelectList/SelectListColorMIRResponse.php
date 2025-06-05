<?php

namespace ImportSystem\ColorMIR\Application\SelectList;

class SelectListColorMIRResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListColorMIRResponse constructor.
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
