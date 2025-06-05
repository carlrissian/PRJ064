<?php

namespace ImportSystem\Fleet\Domain;

use PhpOffice\PhpSpreadsheet\Spreadsheet;

interface FileRepository
{
    /**
     * @param \SplFileInfo $file
     * @return array
     */
    public function import(\SplFileInfo $file): array;

    /**
     * @param array $data
     * @param array $dropdownLists
     * @param string|null $fileName
     * @param bool $returnFile
     * @return Spreadsheet|array
     */
    public function export(array $data, array $dropdownLists, ?string $fileName = null, bool $returnFile = false);
}
