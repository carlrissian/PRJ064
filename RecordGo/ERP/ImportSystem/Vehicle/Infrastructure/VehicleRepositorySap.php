<?php

namespace ImportSystem\Vehicle\Infrastructure;

use Closure;
use Exception;
use ImportSystem\Vehicle\Domain\Vehicle;
use ImportSystem\Vehicle\Domain\VehicleCollection;
use ImportSystem\Vehicle\Domain\VehicleCriteria;
use ImportSystem\Vehicle\Domain\VehicleException;
use ImportSystem\Vehicle\Domain\VehicleGetByResponse;
use ImportSystem\Vehicle\Domain\VehicleRepository;
use ImportSystem\Vehicle\Domain\VehicleStatus;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Shared\Repository\RepositoryHelper;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;


class VehicleRepositorySap extends RepositoryHelper implements VehicleRepository
{
    const PREFIX_FUNCTION_NAME = 'Vehicle/VehicleRepository';
    const PREFIX_FUNCTION_UPDATE_VEHICLE = "Vehicle/VehicleRepository_ModifyCampa";
    /**
     * @var SapRequestHelper $sapRequestHelper
     */
    public SapRequestHelper $sapRequestHelper;

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        parent::__construct($sapRequestHelper);
    }

    public function getBy(VehicleCriteria $criteria): VehicleGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new VehicleCollection([]);
        try {
            $bodyArray = RepositoryHelper::createCriteria($criteria);
            $body = json_encode($bodyArray);
            $totalRows = $this->genericGetBy('GET', $functionName, $body, 'TVehicleResponse', $collection,
                Closure::fromCallable([$this, 'arrayVehicle']));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
        return new VehicleGetByResponse($collection, $totalRows ?? 0);

    }

    public function update(Vehicle $vehicle): int
    {
        $functionName = self::PREFIX_FUNCTION_UPDATE_VEHICLE . '_' . __FUNCTION__;

        try {
            $body = Vehicle::createToArray($vehicle);
            $request = $this->save('PATCH', $functionName, json_encode($body));
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return $request;
    }

    public function arrayVehicle(array $arrayVehicle): Vehicle
    {
        return Vehicle::createFromArray($arrayVehicle);
    }

    public function save(string $method, string $functionName, string $body): int
    {
        try {
            $response = $this->sapRequestHelper->request($method, $functionName, $body);
            $responseArray = json_decode($response, true);
            if (isset($responseArray['errorCode']) && $responseArray['errorCode'] === '400') {
                throw new BadRequestHttpException('Mandatory fields are required', null, 400);
            }
            if (isset($responseArray['errorCode']) && $responseArray['errorCode'] === '500') {
                throw new HttpException(500, $responseArray['Notas']);
            }
            if (!$responseArray) {
                throw new Exception('Something fail during save');
            }

            $ret = intval($responseArray['SUCCESS']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        return $ret;

    }
}