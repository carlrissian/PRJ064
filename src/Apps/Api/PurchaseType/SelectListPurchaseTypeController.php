<?php

namespace App\Apps\Api\PurchaseType;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\PurchaseType\Application\SelectList\SelectListPurchaseTypeQueryHandler;

class SelectListPurchaseTypeController extends AbstractController
{
    /**
     * @var SelectListPurchaseTypeQueryHandler
     */
    private $handler;

    /**
     * @param SelectListPurchaseTypeQueryHandler $handler
     */
    public function __construct(SelectListPurchaseTypeQueryHandler $handler)
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
