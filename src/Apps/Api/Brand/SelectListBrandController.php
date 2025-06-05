<?php

namespace App\Apps\Api\Brand;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\Brand\Application\SelectList\SelectListBrandQueryHandler;

class SelectListBrandController extends AbstractController
{
    /**
     * @var SelectListBrandQueryHandler
     */
    private $handler;

    /**
     * @param SelectListBrandQueryHandler $handler
     */
    public function __construct(SelectListBrandQueryHandler $handler)
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
