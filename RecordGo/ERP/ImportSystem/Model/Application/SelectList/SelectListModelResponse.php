<?php

namespace ImportSystem\Model\Application\SelectList;

class SelectListModelResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListModelResponse constructor.
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
