<?php

namespace ImportSystem\Trim\Application\SelectList;

class SelectListTrimResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListTrimResponse constructor.
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
