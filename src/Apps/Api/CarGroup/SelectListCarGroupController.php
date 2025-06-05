<?php

namespace App\Apps\Api\CarGroup;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\CarGroup\Application\SelectList\SelectListCarGroupQueryHandler;

class SelectListCarGroupController extends AbstractController
{
    /**
     * @var SelectListCarGroupQueryHandler
     */
    private $handler;

    /**
     * @param SelectListCarGroupQueryHandler $handler
     */
    public function __construct(SelectListCarGroupQueryHandler $handler)
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
