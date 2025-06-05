<?php

namespace App\Apps\Api\Location;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\Location\Application\SelectList\SelectListLocationQueryHandler;

class SelectListLocationController extends AbstractController
{
    /**
     * @var SelectListLocationQueryHandler
     */
    private $handler;

    /**
     * @param SelectListLocationQueryHandler $handler
     */
    public function __construct(SelectListLocationQueryHandler $handler)
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
