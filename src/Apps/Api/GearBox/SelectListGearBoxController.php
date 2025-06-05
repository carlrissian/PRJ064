<?php

namespace App\Apps\Api\GearBox;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\GearBox\Application\SelectList\SelectListGearBoxQueryHandler;

class SelectListGearBoxController extends AbstractController
{
    /**
     * @var SelectListGearBoxQueryHandler
     */
    private $handler;

    /**
     * @param SelectListGearBoxQueryHandler $handler
     */
    public function __construct(SelectListGearBoxQueryHandler $handler)
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
