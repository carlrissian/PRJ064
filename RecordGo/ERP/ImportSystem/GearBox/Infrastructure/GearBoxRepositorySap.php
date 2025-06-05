<?php

namespace ImportSystem\GearBox\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\GearBox\Domain\GearBox;
use ImportSystem\GearBox\Domain\GearBoxCriteria;
use ImportSystem\GearBox\Domain\GearBoxCollection;
use ImportSystem\GearBox\Domain\GearBoxRepository;
use ImportSystem\GearBox\Domain\GearBoxGetByResponse;

final class GearBoxRepositorySap extends RepositoryHelper implements GearBoxRepository
{
    private const PREFIX_FUNCTION_NAME = 'GearBox/GearBoxRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(GearBoxCriteria $criteria): GearBoxGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new GearBoxCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TBasicGearBoxResponse');

            foreach ($responseArray['TBasicGearBoxResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToGearBox($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new GearBoxGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @throws Exception
     */
    // final public function getById(int $id): GearBox
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;
    //     $method = 'GET';
    //     try {
    //         $response = $this->sapRequestHelper->request($method, $functionName, '');
    //         if ($response === false) {
    //             throw new Exception('Something fail during query');
    //         }
    //         $responseArray = json_decode($response, true);
    //         if (!$responseArray || !isset($responseArray['TBasicGearBoxResponse'])) {
    //             throw new Exception('Something fail during getById ');
    //         }
    //         $gearArray = $responseArray['TBasicGearBoxResponse'][0];
    //         $area = $this->arrayToGearBox($gearArray);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    //     return $area;
    // }


    final public function arrayToGearBox(array $gearBoxArray): GearBox
    {
        return GearBox::createFromArray($gearBoxArray);
    }
}
