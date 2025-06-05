<?php

namespace ImportSystem\Provider\Infrastructure;

use Shared\Repository\RepositoryHelper;
use ImportSystem\Provider\Domain\Provider;
use Symfony\Component\HttpFoundation\Response;
use ImportSystem\Provider\Domain\ProviderCriteria;
use ImportSystem\Provider\Domain\ProviderCollection;
use ImportSystem\Provider\Domain\ProviderRepository;
use ImportSystem\Provider\Domain\ProviderGetByResponse;

final class ProviderRepositorySap extends RepositoryHelper implements ProviderRepository
{
    public const PREFIX_FUNCTION_NAME = 'Supplier/SupplierRepository';

    /**
     * @inheritDoc
     * @throws Exception
     */
    final public function getBy(ProviderCriteria $criteria): ProviderGetByResponse
    {
        $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;
        $collection = new ProviderCollection([]);

        try {
            $body = json_encode(parent::createCriteria($criteria));

            $response  = $this->sapRequestHelper->request('GET', $functionName, $body);

            if ($response === false) {
                throw new \Exception(sprintf("The %s request hasn't returned a response", __FUNCTION__));
            }
            $responseArray = json_decode($response, true);
            $this->errorHandling($responseArray, $response, 'TSupplierResponse');

            foreach ($responseArray['TSupplierResponse'] as $itemArray) {
                try {
                    $collection->add($this->arrayToProvider($itemArray));
                } catch (\Exception $exception) {
                    throw new \Exception($exception->getMessage(), $exception->getCode());
                }
            }
            $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : $collection->count();
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new ProviderGetByResponse($collection, $totalRows ?? 0);
    }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function getById(int $id): ?Provider
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $id;

    //     try {
    //         $providerArray = $this->genericGetById('GET', $functionName, 'TProviderResponse');

    //         return Provider::createFromArray($providerArray);
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function store(Provider $provider): ?int
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__;

    //     try {
    //         $body = json_encode($provider->toArray());

    //         $response = $this->genericSave('POST', $functionName, $body);

    //         return $response;
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }

    /**
     * @inheritDoc
     * @throws Exception
     */
    // final public function update(Provider $provider): ?int
    // {
    //     $functionName = self::PREFIX_FUNCTION_NAME . '_' . __FUNCTION__ . '/' . $provider->getId();

    //     try {
    //         $body = json_encode($provider->toArray());

    //         $response = $this->genericSave('PATCH', $functionName, $body);

    //         return $response;
    //     } catch (Exception $exception) {
    //         throw new Exception($exception->getMessage(), $exception->getCode());
    //     }
    // }


    final private function arrayToProvider(array $providerArray): Provider
    {
        return Provider::createFromArray($providerArray);
    }
}
