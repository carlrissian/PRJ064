<?php

namespace App\Apps\View\Fleet;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ImportFleetController extends Controller
{

    public function __invoke(): Response
    {
        return $this->render('pages/fleet/importFleet.html.twig');
    }
}