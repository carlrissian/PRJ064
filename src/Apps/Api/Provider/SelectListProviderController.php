<?php

namespace App\Apps\Api\Provider;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\Provider\Application\SelectList\SelectListProviderQueryHandler;

class SelectListProviderController extends AbstractController
{
    /**
     * @var SelectListProviderQueryHandler
     */
    private $handler;

    /**
     * @param SelectListProviderQueryHandler $handler
     */
    public function __construct(SelectListProviderQueryHandler $handler)
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
