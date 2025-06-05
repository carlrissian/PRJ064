<?php

namespace App\Apps\Api\Model;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\Model\Application\SelectList\SelectListModelQueryHandler;

class SelectListModelController extends AbstractController
{
    /**
     * @var SelectListModelQueryHandler
     */
    private $handler;

    /**
     * @param SelectListModelQueryHandler $handler
     */
    public function __construct(SelectListModelQueryHandler $handler)
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
