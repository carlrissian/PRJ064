<?php

namespace App\Apps\Api\Acriss;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\Acriss\Application\SelectList\SelectListAcrissQueryHandler;

class SelectListAcrissController extends AbstractController
{
    /**
     * @var SelectListAcrissQueryHandler
     */
    private $handler;

    /**
     * @param SelectListAcrissQueryHandler $handler
     */
    public function __construct(SelectListAcrissQueryHandler $handler)
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
