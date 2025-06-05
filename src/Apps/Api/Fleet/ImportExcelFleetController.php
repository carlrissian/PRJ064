<?php

namespace App\Apps\Api\Fleet;

use App\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ImportSystem\Fleet\Domain\ImportFleetExcelException;
use ImportSystem\Fleet\Application\ImportExcelFleet\ImportExcelFleetCommand;
use ImportSystem\Fleet\Application\ImportExcelFleet\ImportExcelFleetCommandHandler;

class ImportExcelFleetController extends Controller
{
    /**
     * @var ImportExcelFleetCommandHandler
     */
    private ImportExcelFleetCommandHandler $handler;

    /**
     * @param ImportExcelFleetCommandHandler $handler
     */
    public function __construct(ImportExcelFleetCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $file = $request->files->get('file');

            $command = new ImportExcelFleetCommand($file);

            $response = $this->handler->handle($command);
        } catch (ImportFleetExcelException $e) {
            return $this->json([
                'message' => $e->getMessage(),
                'vehicles' => $e->getData(),
            ], $e->getCode());
        }

        return $this->json($response, $response->isSuccess() ? Response::HTTP_OK : Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
