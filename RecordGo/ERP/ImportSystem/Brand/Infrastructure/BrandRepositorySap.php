<?php

namespace ImportSystem\Brand\Infrastructure;

use ImportSystem\Brand\Domain\Brand;
use Shared\Repository\RepositoryHelper;
use ImportSystem\Brand\Domain\BrandCriteria;
use ImportSystem\Brand\Domain\BrandCollection;
use ImportSystem\Brand\Domain\BrandRepository;
use Symfony\Component\HttpFoundation\Response;
use ImportSystem\Brand\Domain\BrandGetByResponse;

final class BrandRepositorySap extends RepositoryHelper implements BrandRepository
{
    public const PREFIX_FUNCTION_NAME = 'Brand/BrandRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(BrandCriteria $criteria): BrandGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new BrandCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TBrandResponse');

            foreach ($responseArray['TBrandResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToBrand($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new BrandGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): ?Brand
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $response = $this->sapRequestHelper->request('GET', $functionName,  '');
    //         $responseArray = json_decode($response, true);

    //         return Brand::createFromArray($responseArray['TBrandResponse']);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }


    final private function arrayToBrand(array $brandArray): Brand
    {
        return Brand::createFromArray($brandArray);
    }
}
