<?php

namespace App\Apps\View\Vehicle;

use App\Controller\Controller;
use ImportSystem\Vehicle\Application\ExportExcelVehicle\ExportExcelVehicleCommandHandler;
use Symfony\Component\HttpFoundation\Response;


class ImportExcelVehicleController extends Controller
{

    /**
     * @var ExportExcelVehicleCommandHandler $handler
     */
    private ExportExcelVehicleCommandHandler $handler;

    /**
     * @param ExportExcelVehicleCommandHandler $handler
     */
    public function __construct(ExportExcelVehicleCommandHandler $handler)
    {
        $this->handler = $handler;
    }


    public function __invoke():Response
    {

        $response= $this->handler->handle();

        return $this->render('pages/vehicle/importExcelVehicle.html.twig',
            [
                'vehicleList'=>$this->json($response->getVehicleResponse())->getContent(),
                'vehicleStatusList'=> $this->json($response->getVehicleStatus())->getContent()

            ]);
    }
}