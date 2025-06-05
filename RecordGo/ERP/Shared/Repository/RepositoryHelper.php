<?php

declare(strict_types=1);

namespace Shared\Repository;

use Closure;
use Exception;
use Shared\Domain\Collection;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\RequestHelper\SapRequestHelper;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class RepositoryHelper
{
    /**
     * @var SapRequestHelper
     */
    protected SapRequestHelper $sapRequestHelper;

    /**
     * @param SapRequestHelper $sapRequestHelper
     */
    public function __construct(SapRequestHelper $sapRequestHelper)
    {
        $this->sapRequestHelper = $sapRequestHelper;
    }

    /**
     * @deprecated Don't use it for the moment
     * @throws Exception
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    final public function genericGetBy(string $method, string $functionName, string $body, string $tType, Collection &$collection, Closure $convert): int
    {
        $response = $this->sapRequestHelper->request($method, $functionName, $body);

        if ($response === false) {
            throw new Exception("The getBy request hasn't returned a response");
        }

        $responseArray = json_decode($response, true);
        $this->errorHandling($responseArray, $response, $tType);

        $collectionArray = $responseArray[$tType];
        $totalRows = (isset($responseArray['TotalRows'])) ? $responseArray['TotalRows'] : count($collectionArray);

        foreach ($collectionArray as $itemArray) {
            $collection->add($convert($itemArray));
        }

        return $totalRows ?? 0;
    }

    /**
     * @deprecated Don't use it for the moment
     * @throws Exception
     * @noinspection PhpParameterByRefIsNotUsedAsReferenceInspection
     */
    final public function genericGetById(string $method, string $functionName, string $tType): array
    {
        $response = $this->sapRequestHelper->request($method, $functionName, '');

        if ($response === false) {
            throw new Exception("The getById request hasn't returned a response", 500);
        }

        $responseArray = json_decode($response, true);
        $this->errorHandling($responseArray, $response, $tType);
        return $responseArray[$tType][0] ?? [];
    }

    /**
     * @deprecated Don't use it for the moment
     * @throws Exception
     */
    final public function genericSave(string $method, string $functionName, string $body): int
    {
        try {
            $response = $this->sapRequestHelper->request($method, $functionName, $body);
            $responseArray = json_decode($response, true);

            if (!$responseArray) {
                throw new Exception('Something went wrong during the save request', 500);
            }

            $this->errorHandling($responseArray, $response, 'ID');
            return intval($responseArray['ID']);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }
    }


    /**
     * Función para generar estructura Filtro y Paginación para repositorios (GetBy)
     * 
     * @param Criteria $criteria
     * @param string $condition
     * @return array
     */
    final public static function createCriteria(Criteria $criteria, string $condition = 'AND'): array
    {
        $paginationArray = [];
        if ($criteria->hasPagination()) {
            $pagination = $criteria->getPagination();

            $sortArray = [];
            if ($pagination->getSort()) {
                foreach ($pagination->getSort() as $sort) {
                    if ($sort->getSort() !== 'undefined') {
                        $sortArray[] = [
                            'TSortRequest' => [
                                'sort' => $sort->getSort(),
                                'order' => $sort->getOrder()
                            ]
                        ];
                    }
                }
            }

            $paginationArray = [
                'limit' => $pagination->getLimit(),
                'offset' => $pagination->getOffset(),
                'sort' => $sortArray
            ];
        }


        $filterArray = [];
        if ($criteria->hasFilters()) {
            $filterArray['condition'] = $condition;

            foreach ($criteria->getFilters() as $filter) {
                $filterArray['TFilter'][] = [
                    'field' => $filter->getField(),
                    'operador' => $filter->getOperator()->value(),
                    'value' => self::formatValue($filter->getValue())
                ];
            }
        }

        $bodyArray = [];
        if (!empty($paginationArray)) {
            $bodyArray['TPaginationRequest'] = $paginationArray;
        }
        if (!empty($filterArray)) {
            $bodyArray['TFilterRequest'] = $filterArray;
        }

        return $bodyArray;
    }

    /**
     * 
     *
     * @param Collection|null $collection
     * @param string|null $key
     * @param boolean $convertToString
     * @return array|null
     */
    final public static function collectionToArrayIdForRequest(?Collection $collection, ?string $key = 'ID', bool $convertToString = false): ?array
    {
        $collectionArray = ($collection !== null) ? $collection->toArray() : [];
        $collectionIds = [];
        for ($i = 0; $i < count($collectionArray); $i++) {
            if ($key === null) {
                $collectionIds[] = ($convertToString) ? (string)$collectionArray[$i]->getId() : $collectionArray[$i]->getId();
            } else {
                $collectionIds[] = [$key => (($convertToString) ? (string)$collectionArray[$i]->getId() : $collectionArray[$i]->getId())];
            }
        }
        return (count($collectionIds) > 0) ? $collectionIds : null;
    }

    /**
     * @throws Exception
     */
    public function errorHandling(array $responseArray, string $response, string $tType): void
    {
        if (!$responseArray || !isset($responseArray[$tType])) {
            if (isset($responseArray['errorCode'])) {
                $message = $this->extractMessage($responseArray);

                switch (intval($responseArray['errorCode'])) {
                    case 400:
                        throw new BadRequestHttpException('Mandatory fields are required. ' . $message, null, 400);
                    case 460:
                        $message = $responseArray['Notas'];
                        throw new Exception($message, 460);
                        // case 500:
                        //     throw new HttpException(500, $message);
                    default:
                        throw new Exception($message, intval($responseArray['errorCode']));
                }
            }

            throw new Exception($response, 500);
        }
    }

    private function extractMessage(array $responseArray): string
    {
        $message = '';
        if (isset($responseArray['errorDescription']) && $responseArray['errorDescription'] !== '') {
            $message .= "Error description: " . $responseArray['errorDescription'];
        }
        if (isset($responseArray['Notas']) && $responseArray['Notas'] !== '') {
            $message .= "\nNotas: " . $responseArray['Notas'];
        }
        return $message;
    }
    /**
     * @param $value
     * @return int|mixed|string
     */
    private static function formatValue($value)
    {
        if (is_array($value)) {
            // transform array into string '[1,2,3]'
            $value = '[' . implode(',', $value) . ']';
        } elseif (is_bool($value)) {
            $value = $value ? 1 : 0;
        } elseif (is_string($value)) {
            $value = trim($value);
        }

        return $value;
    }
}
