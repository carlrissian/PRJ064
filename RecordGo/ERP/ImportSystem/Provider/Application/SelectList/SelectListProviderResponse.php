<?php

namespace ImportSystem\Provider\Application\SelectList;

class SelectListProviderResponse
{
    /**
     * @var array
     */
    private $selectList;

    /**
     * SelectListProviderResponse constructor.
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
