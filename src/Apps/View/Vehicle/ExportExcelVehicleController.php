<?php

namespace App\Apps\View\Vehicle;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExportExcelVehicleController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('pages/vehicle/exportExcelVehicle.html.twig');
    }
}