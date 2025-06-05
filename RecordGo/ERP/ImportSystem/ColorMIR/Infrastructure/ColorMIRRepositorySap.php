<?php

namespace ImportSystem\ColorMIR\Infrastructure;

use ImportSystem\ColorMIR\Domain\ColorMIR;
use Shared\Repository\RepositoryHelper;
use ImportSystem\ColorMIR\Domain\ColorMIRCriteria;
use ImportSystem\ColorMIR\Domain\ColorMIRCollection;
use ImportSystem\ColorMIR\Domain\ColorMIRRepository;
use Symfony\Component\HttpFoundation\Response;
use ImportSystem\ColorMIR\Domain\ColorMIRGetByResponse;

final class ColorMIRRepositorySap extends RepositoryHelper implements ColorMIRRepository
{
    public const PREFIX_FUNCTION_NAME = 'ColorMIR/ColorMIRRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(ColorMIRCriteria $criteria): ColorMIRGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new ColorMIRCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TColorMIRResponse');

            foreach ($responseArray['TColorMIRResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToColorMIR($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ColorMIRGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): ?ColorMIR
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $response = $this->sapRequestHelper->request('GET', $functionName,  '');
    //         $responseArray = json_decode($response, true);

    //         return ColorMIR::createFromArray($responseArray['TColorMIRResponse']);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }


    final private function arrayToColorMIR(array $ColorMIRArray): ColorMIR
    {
        return ColorMIR::createFromArray($ColorMIRArray);
    }
}
