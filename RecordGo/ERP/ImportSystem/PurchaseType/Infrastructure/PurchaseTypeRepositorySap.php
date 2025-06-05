<?php

namespace ImportSystem\PurchaseType\Infrastructure;

use Shared\Repository\RepositoryHelper;
use Symfony\Component\HttpFoundation\Response;
use ImportSystem\PurchaseType\Domain\PurchaseType;
use ImportSystem\PurchaseType\Domain\PurchaseTypeCriteria;
use ImportSystem\PurchaseType\Domain\PurchaseTypeCollection;
use ImportSystem\PurchaseType\Domain\PurchaseTypeRepository;
use ImportSystem\PurchaseType\Domain\PurchaseTypeGetByResponse;

final class PurchaseTypeRepositorySap extends RepositoryHelper implements PurchaseTypeRepository
{
    private const PREFIX_FUNCTION_NAME = 'PurchaseType/PurchaseTypeRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(PurchaseTypeCriteria $criteria): PurchaseTypeGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new PurchaseTypeCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TPurchaseTypeResponse');

            foreach ($responseArray['TPurchaseTypeResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToPurchaseType($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new PurchaseTypeGetByResponse($collection, $totalRows ?? 0);
    }


    final private function arrayToPurchaseType(array $purchaseTypeArray): PurchaseType
    {
        return PurchaseType::createFromArray($purchaseTypeArray);
    }
}
