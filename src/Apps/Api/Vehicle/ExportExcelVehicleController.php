<?php

namespace App\Apps\Api\Vehicle;

use App\Controller\Controller;
use App\Services\ExportTo;
use Exception;
use ImportSystem\Vehicle\Application\ExportExcelVehicle\ExportExcelVehicleCommandHandler;
use Symfony\Component\HttpFoundation\Request;

class ExportExcelVehicleController extends Controller
{
    private ExportExcelVehicleCommandHandler $handler;

    public function __construct(ExportExcelVehicleCommandHandler $handler){
        $this->handler = $handler;
    }

    public function __invoke(Request $request){

        try {
            $response = $this->handler->handle();
        }catch (Exception $e){
            return $this->json(['message' => $e->getMessage()], $e->getCode());
        }

        $date = date("DD-mm-YYYY");
        $fileName = "Vehicles_".$date.".xlsx";

        ExportTo::exportToListXls($response->getVehicleResponse(),$fileName);
    }
}