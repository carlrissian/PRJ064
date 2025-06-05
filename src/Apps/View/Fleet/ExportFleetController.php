<?php

namespace App\Apps\View\Fleet;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ExportFleetController extends Controller
{
    public function __invoke(): Response
    {
        return $this->render('pages/fleet/exportFleet.html.twig');
    }
}