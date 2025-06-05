<?php

namespace App\Apps\Api\VehicleStatus;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\VehicleStatus\Application\SelectList\SelectListVehicleStatusQueryHandler;

class SelectListVehicleStatusController extends AbstractController
{
    /**
     * @var SelectListVehicleStatusQueryHandler
     */
    private $handler;

    /**
     * @param SelectListVehicleStatusQueryHandler $handler
     */
    public function __construct(SelectListVehicleStatusQueryHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        $response = $this->handler->handle();

        return $this->json($response->getSelectList());
    }
}
