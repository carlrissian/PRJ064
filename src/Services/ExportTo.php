<?php


namespace App\Services;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportTo
{
    public static function exportToXls($arrayList, $fileName){
        $self = new self();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');

        $spreadsheet = new Spreadsheet();

        $row = 1;
        $sheet = $spreadsheet->getActiveSheet();

        $i = 1;

        foreach($arrayList as $array) {
            foreach ($array as $value) {
                if(is_array($value["value"])) {
                    foreach ($value["value"] as $value2) {
                        foreach ($value2 as $value3) {
                            $sheet->getCellByColumnAndRow($i, $row)->getStyle()->getFont()->setBold(true);
                            $sheet->setCellValueByColumnAndRow($i, $row, strtoupper($value3["title"]));
                            $sheet->setCellValueByColumnAndRow($i, $row + 1, strtoupper($value3["value"]));
                            $i++;
                        }
                    }
                }else {
                    $sheet->getCellByColumnAndRow($i, $row)->getStyle()->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow($i, $row, strtoupper($value["title"]));
                    $sheet->setCellValueByColumnAndRow($i, $row + 1, strtoupper($value["value"]));
                    $i++;
                }
            }
            $row = $row +2;
            $i = 1;
        }
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save("php://output");
    }

    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function  exportToListXls($arrayList, $fileName){

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$fileName.'"');

        $spreadsheet = new Spreadsheet();


        $row = 1;
        $sheet = $spreadsheet->getActiveSheet();
        $i = 1;

        foreach($arrayList as $array) {
            foreach ($array as $value) {

                if($row === 1) {
                    $sheet->getCellByColumnAndRow($i, $row)->getStyle()->getFont()->setBold(true);
                    $sheet->setCellValueByColumnAndRow($i, $row, $value["title"]);
                }

                if (str_contains($value['title'], 'Fecha')) {
                    if ($value["value"] != null){

                        $sheet->setCellValueByColumnAndRow($i, $row+1, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($value["value"]));
                        $sheet->getStyleByColumnAndRow($i, $row+1)
                            ->getNumberFormat()
                            ->setFormatCode('d/m/Y H:i:s');
                    }
                }else{
                    $sheet->setCellValueByColumnAndRow($i, $row+1, $value["value"]);
                }


                $i++;
            }

            $row++;
            $i = 1;
        }

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save("php://output");
        die;
    }

}