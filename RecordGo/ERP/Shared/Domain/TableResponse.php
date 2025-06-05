<?php


namespace Shared\Domain;


/**
 * Class TableResponse
 * @package Shared\Domain
 */
class TableResponse
{
    /**
     * @var int
     */
    private $totalRows;
    /**
     * @var array
     */
    private $data;

    /**
     * TableResponse constructor.
     * @param $totalRows
     * @param $data
     */
    private function __construct(int $totalRows, array $data)
    {
        $this->totalRows = $totalRows;
        $this->data = $data;
    }

    /**
     * @return int
     */
    public function getTotalRows(): int
    {
        return $this->totalRows;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param int $totalRows
     * @param array $data
     * @return TableResponse
     */
    public static function create(int $totalRows, array $data)
    {
        return new self($totalRows, $data);
    }

}