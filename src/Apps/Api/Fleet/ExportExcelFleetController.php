<?php

namespace App\Apps\Api\Fleet;

use App\Controller\Controller;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ImportSystem\Fleet\Application\ExportExcelFleet\ExportExcelFleetCommand;
use ImportSystem\Fleet\Application\ExportExcelFleet\ExportExcelFleetCommandHandler;

class ExportExcelFleetController extends Controller
{
    private ExportExcelFleetCommandHandler $handler;

    public function __construct(ExportExcelFleetCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @return BinaryFileResponse
     * 
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function __invoke(Request $request): BinaryFileResponse
    {
        $command = new ExportExcelFleetCommand(
            json_decode($request->get('providerId', '[]')),
            json_decode($request->get('bbCustomerId', '[]')),
            json_decode($request->get('purchaseTypeId', '[]')),
            json_decode($request->get('saleMethodId', '[]')),
            json_decode($request->get('brandId', '[]')),
            json_decode($request->get('modelId', '[]')),
            json_decode($request->get('trimId', '[]')),
            json_decode($request->get('carGroupId', '[]')),
            json_decode($request->get('vehicleTypeId', '[]')),
            json_decode($request->get('acrissId', '[]')),
            json_decode($request->get('gearBoxId', '[]')),
            json_decode($request->get('motorizationTypeId', '[]')),
            json_decode($request->get('receptionLocationId', '[]')),
            json_decode($request->get('vehicleStatusId', '[]')),
            json_decode($request->get('actualLocationId', '[]')),
            $request->get('firstRegistrationDateFrom'),
            $request->get('firstRegistrationDateTo'),
            $request->get('lastRegistrationDateFrom'),
            $request->get('lastRegistrationDateTo'),
            $request->get('deliveryDateFrom'),
            $request->get('deliveryDateTo'),
            $request->get('returnDateFrom'),
            $request->get('returnDateTo'),
            $request->get('firstRentDateFrom'),
            $request->get('firstRentDateTo'),
            $request->get('rentingEndDateFrom'),
            $request->get('rentingEndDateTo'),
            $request->get('creationDateFrom'),
            $request->get('creationDateTo'),
            filter_var($request->get('operative'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
            filter_var($request->get('noLicensePlate'), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE)
        );

        $handlerResponse = $this->handler->handle($command);
        $response = new BinaryFileResponse($handlerResponse->getTempFile());
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, $handlerResponse->getFileName() ?? $response->getFile()->getFilename());
        return $response;
    }
}
