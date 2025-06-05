<?php

namespace App\Apps\Api\SaleMethod;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\SaleMethod\Application\SelectList\SelectListSaleMethodQueryHandler;

class SelectListSaleMethodController extends AbstractController
{
    /**
     * @var SelectListSaleMethodQueryHandler
     */
    private $handler;

    /**
     * @param SelectListSaleMethodQueryHandler $handler
     */
    public function __construct(SelectListSaleMethodQueryHandler $handler)
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
