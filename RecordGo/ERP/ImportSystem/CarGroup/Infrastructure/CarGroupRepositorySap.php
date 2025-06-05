<?php

namespace ImportSystem\CarGroup\Infrastructure;

use Shared\Utils\Utils;
use Shared\Repository\RepositoryHelper;
use ImportSystem\CarGroup\Domain\CarGroup;
use ImportSystem\CarGroup\Domain\CarGroupCriteria;
use ImportSystem\CarGroup\Domain\CarGroupCollection;
use ImportSystem\CarGroup\Domain\CarGroupRepository;
use ImportSystem\CarGroup\Domain\CarGroupGetByResponse;
use Symfony\Component\HttpFoundation\Response;

class CarGroupRepositorySap extends RepositoryHelper implements CarGroupRepository
{
    private const PREFIX_FUNCTION_NAME = 'CarGroup/CarGroupRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(CarGroupCriteria $criteria): CarGroupGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new CarGroupCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TCarGroupResponse');

            foreach ($responseArray['TCarGroupResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToCarGroup($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new CarGroupGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): ?CarGroup
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;
    //     $method = 'GET';
    //     try {
    //         $response = $this->sapRequestHelper->request($method, $functionName, '');
    //         if ($response === false) {
    //             throw new Exception('Something fail during query');
    //         }
    //         $responseArray = json_decode($response, true);
    //         if (!$responseArray || !isset($responseArray['TCarGroupResponse'])) {
    //             throw new Exception('Something fail during getById');
    //         }
    //         $carGroupArray = $responseArray['TCarGroupResponse'][0];
    //         $carGroup = $this->arrayToCarGroup($carGroupArray);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    //     return $carGroup;
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function store(CarGroup $carGroup): int
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
    //     $method = 'POST';

    //     try {
    //         $settingArray = $carGroup->toArray();
    //         $body = json_encode($settingArray);
    //         $ret = $this->genericSave($method, $functionName, $body);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    //     return $ret;
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function update(CarGroup $carGroup): int
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $carGroup->getId();
    //     $method = 'PATCH';

    //     try {
    //         $settingArray = $carGroup->toArray();
    //         $body = json_encode($settingArray);
    //         $ret = $this->genericSave($method, $functionName, $body);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    //     return $ret;
    // }


    final private function arrayToCarGroup(array $carGroupArray): CarGroup
    {
        return CarGroup::createFromArray($carGroupArray);
    }
}
