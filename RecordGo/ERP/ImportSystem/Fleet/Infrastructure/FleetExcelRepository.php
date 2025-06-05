<?php

namespace ImportSystem\Fleet\Infrastructure;

use Shared\Utils\ExcelUtils;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use ImportSystem\Fleet\Domain\FileRepository;
use ImportSystem\Fleet\Domain\FleetExcelColumns;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

final class FleetExcelRepository implements FileRepository
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function import(\SplFileInfo $file): array
    {
        $reader = new XlsxReader();

        $spreadsheet = $reader->load($file);
        $worksheet = $spreadsheet->getActiveSheet();

        $headers = [];
        $dataList = [];
        foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
            $cellIterator = $row->getCellIterator();

            if ($rowIndex === 1) {
                $headers = array_map(function ($cell) {
                    return $cell->getValue();
                }, iterator_to_array($cellIterator));
            } else {
                $line = [];
                $line["line"] = $rowIndex;

                foreach ($cellIterator as $columnIndex => $cell) {
                    $columnName = $worksheet->getCell($columnIndex . 1)->getValue();
                    $value = null;
                    if (!is_null($cell->getValue())) {
                        if ($cell->getDataType() === \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC && str_contains(strtolower($columnName), 'f.')) {
                            $value = ExcelUtils::convertExcelTImeToTimestamp($cell->getValue());
                        } elseif (Date::isDateTime($cell)) {
                            $value = Date::excelToTimestamp($cell->getValue());
                        } else {
                            $value = $cell->getValue();
                        }
                    }
                    $line[$columnName] = $value;
                }

                $dataList[] = $line;
            }
        }

        return [$headers, $dataList];
    }

    /**
     * @inheritDoc
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export(array $data, array $dropdownLists, ?string $fileName = null, bool $returnFile = false)
    {
        $headers = FleetExcelColumns::getAllColumns();

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        /**
         * Crear listados de ocpiones en una hoja oculta
         */
        $dropdownCols = [];
        $spreadsheet->createSheet();
        $sheet = $spreadsheet->setActiveSheetIndex(1);
        $sheet->setTitle('DropdownLists');

        $col = 'A';
        foreach ($dropdownLists as $head => $dropdownList) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->getColumnDimension($col)->setVisible(false);

            $row = 1;
            foreach ($dropdownList['values'] as $value) {
                $sheet->setCellValue("{$col}{$row}", $value);
                $row++;
            }

            $dropdownCols[$head] = [
                'index' => $col,
                'allowBlank' => $dropdownList['allowBlank'],
                'listRange' => "'{$sheet->getTitle()}'!\${$col}\$1:\${$col}\$" . (count($dropdownList['values'])),
            ];

            $col++;
        }

        // Ocultar la hoja
        $sheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_VERYHIDDEN);
        /* */


        // Retrieve the current active worksheet
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $col = 'A';
        foreach ($headers as $header) {
            $head = $header['name'];
            $sheet->getColumnDimension($col)->setAutoSize(true);
            $sheet->setCellValue("{$col}1", $head);

            $hasDropDown = $header['dropdown'] && array_key_exists($head, $dropdownCols);
            // Recoger sólo los valores de la columna
            $colData = array_values(array_map(function ($item) {
                return $item['value'] ?? null;
            }, array_filter(array_merge(...$data), function ($item) use ($head) {
                return isset($item['title']) && $item['title'] === $head;
            })));
            $startRow = 2;
            $endRow = count($colData) + $startRow;

            if ($hasDropDown) {
                $validation = $sheet->getCell("{$col}{$startRow}")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);

                // Referencia al rango oculto
                $validation->setFormula1($dropdownCols[$head]['listRange']);

                // INFO: no se puede utilizar así porque el rango de caracteres máximo de la lista es 255
                // $validation->setFormula1('"' . implode(',', $dropdownCols[$head]['values']) . '"');

                $validation->setAllowBlank($dropdownCols[$head]['allowBlank']);
                $validation->setShowDropDown(true);
                // INFO: campos para tooltip
                // $validation->setShowInputMessage(true);
                // $validation->setPromptTitle('Note');
                // $validation->setPrompt('Must select one from the drop down options.');
                $validation->setShowErrorMessage(true);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setErrorTitle('Invalid option');
                $validation->setError('Select an option from the drop down list.');
            }

            for ($i = $startRow; $i <= $endRow; $i++) {
                // Aplicar la validación al rango completo
                if ($hasDropDown) $sheet->getCell("{$col}{$i}")->setDataValidation(clone $validation);
                $sheet->setCellValue("{$col}{$i}", $colData[$i - 2] ?? null);

                $fieldDataType = [
                    "string" => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
                    "int" => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC,
                    "float" => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC,
                    "date" => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
                ];
                $dataType = $header['dropdown'] ? \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING : $fieldDataType[$header['dataType']];
                $sheet->getCell("{$col}{$i}")->setDataType($dataType);
            }

            $col++;
        }

        if ($returnFile) {
            return $spreadsheet;
        } else {
            // Guardar el archivo
            if (empty($fileName)) {
                $datetimenow = (new \DateTime())->format('Y-m-d_H-i');
                $fileName = "FleetExport_{$datetimenow}";
            }
            $tempFile = tempnam(sys_get_temp_dir(), "{$fileName}.xlsx");
            $writer = new XlsxWriter($spreadsheet);
            $writer->save($tempFile);
            return [
                $tempFile,
                "{$fileName}.xlsx",
            ];
        }
    }
}
