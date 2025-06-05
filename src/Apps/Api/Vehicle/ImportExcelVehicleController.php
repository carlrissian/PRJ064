<?php

namespace App\Apps\Api\Vehicle;


use App\Controller\Controller;
use ImportSystem\Vehicle\Application\ImportExcelVehicle\ImportExcelVehicleCommand;
use ImportSystem\Vehicle\Application\ImportExcelVehicle\ImportExcelVehicleCommandHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ImportExcelVehicleController extends Controller
{

    private ImportExcelVehicleCommandHandler $handler;

    public function __construct(ImportExcelVehicleCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $value = ($request->getContent());
        $data = json_decode($value, true);
//        try {
        $command = new ImportExcelVehicleCommand(
            ['items' => $data['item'],
                'vehicles' => $data['vehicles'],
                'vehicleStatusList' => $data['vehicleStatusList']
            ]);


        $handler = $this->handler->handle($command);
        return $this->json($handler);
//        } catch (Exception $exception) {
//            return $this->json(['message' => $exception->getMessage()], $exception->getCode());
//        }

    }


}
