<?php

namespace ImportSystem\Fleet\Application\ImportExcelFleet;

use SplFileInfo;

class ImportExcelFleetCommand
{

    private SplFileInfo $file;

    /**
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    public function getFile(): SplFileInfo
    {
        return $this->file;
    }

}