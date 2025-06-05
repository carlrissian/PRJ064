<?php

namespace ImportSystem\SaleMethod\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\SaleMethod\Domain\SaleMethod;
use ImportSystem\SaleMethod\Domain\SaleMethodCriteria;
use ImportSystem\SaleMethod\Domain\SaleMethodCollection;
use ImportSystem\SaleMethod\Domain\SaleMethodRepository;
use ImportSystem\SaleMethod\Domain\SaleMethodGetByResponse;

class SaleMethodRepositorySap extends RepositoryHelper implements SaleMethodRepository
{
    private const PREFIX_FUNCTION_NAME = 'PurchaseMethod/PurchaseMethodRepository';

    /**
     * @inheritDoc
     */
    final public function getBy(SaleMethodCriteria $criteria): SaleMethodGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new SaleMethodCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }

            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TPurchaseMethodResponse');

            foreach ($responseArray['TPurchaseMethodResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToSaleMethod($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
        }

        return new SaleMethodGetByResponse($collection, $totalRows ?? 0);
    }


    /**
     * @param array $saleMethodArray
     * @return SaleMethod
     */
    private function arrayToSaleMethod(array $saleMethodArray): SaleMethod
    {
        return SaleMethod::createFromArray($saleMethodArray);
    }
}
