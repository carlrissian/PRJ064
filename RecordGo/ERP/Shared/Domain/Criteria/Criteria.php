<?php


namespace Shared\Domain\Criteria;


use Shared\Domain\Pagination\Pagination;

abstract class Criteria
{

    /**
     * @var FilterCollection|null
     */
    private $filterCollection;

    /**
     * @var Pagination|null
     */
    private $pagination;

    /**
     * Criteria constructor.
     * @param FilterCollection|null $filterCollection
     * @param Pagination|null $pagination
     */
    public function __construct(?FilterCollection $filterCollection = null, ?Pagination $pagination = null)
    {
        $this->filterCollection = $filterCollection;
        $this->pagination = $pagination;
//        $this->validateAllowedFields();
    }

    public function hasFilters(): bool
    {
        if(null !== $this->filterCollection) {
            return $this->filterCollection->count() > 0;
        } else {
            return false;
        }
    }

    public function hasPagination(): bool
    {
        return null !== $this->pagination;
    }

    /**
     * TODO Necesario hacer test de esta funcion para ver que se comporta correctamente
     * @param array|null $fields
     * @param array|null $operators
     * @return FilterCollection|null
     */
    public function getFilters(array $fields = null, array $operators = null): ?FilterCollection
    {
        $filterList = $this->filterCollection->toArray();
        /**
         * Busca entre todos los filtros y filtra solo los que coinciden con los fields pasados a la funcion
         */
        if(!empty($fields)) {
            $filterList = array_filter(
                $this->filterCollection->toArray(),
                function ($filter) use ($fields) {
                    /**
                     * @var $filter Filter
                     */
                    foreach ($fields as $field) {
                        if ($filter->getField() == $field) {
                            return true;
                        }
                    }
                    return false;
                }
            );
        }

        if(!empty($operators)) {
            /**
             * Busca entre los filtros ya filtrados por el field, y filtra los que coincidan con los operadores pasados a la funcion
             */
            $filterList = array_filter(
                $filterList,
                function ($filter) use ($operators) {
                    /**
                     * @var $filter Filter
                     */
                    foreach ($operators as $operator) {
                        if ($filter->getOperator() == $operator) {
                            return true;
                        }
                    }
                    return false;
                }
            );
        }

//        $filterList = array_unique(array_merge($filterFieldList,$filterOperatorList), SORT_REGULAR);

        return new FilterCollection(array_values($filterList));
    }

    /**
     * @return Pagination|null
     */
    public function getPagination(): ?Pagination
    {
        return $this->pagination;
    }

    /**
     * Devuelve un array con el conjunto de campos por los que se pueden hacer consultas al API
     * @return array
     */
    public abstract function getAllowedFields(): array;

//    public function validateAllowedFields()
//    {
//        foreach($this->filterCollection as $filter) {
//            if(in_array($filter->))
//        }
//    }
}