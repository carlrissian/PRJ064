<?php

namespace App\Apps\Api\Trim;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use ImportSystem\Trim\Application\SelectList\SelectListTrimQueryHandler;

class SelectListTrimController extends AbstractController
{
    /**
     * @var SelectListTrimQueryHandler
     */
    private $handler;

    /**
     * @param SelectListTrimQueryHandler $handler
     */
    public function __construct(SelectListTrimQueryHandler $handler)
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
