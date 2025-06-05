<?php

namespace App\Apps\Api\Vehicle;

use App\Controller\Controller;
use ImportSystem\Vehicle\Application\VehicleUpdate\VehicleUpdateCommandHandler;
use Symfony\Component\HttpFoundation\Request;

class VehicleUpdateController extends Controller
{
    /**
     * @var VehicleUpdateCommandHandler $handler
     */

    private $handler;

    /**
     * @param VehicleUpdateCommandHandler $handler
     */
    public function __construct(VehicleUpdateCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request)
    {
        $items = ($request->getContent());
        $data = json_decode($items, true);

        $vehicle = $data['updateVehicle'];

        $handler = $this->handler->handler($vehicle);
        return $this->json($handler);

    }

}