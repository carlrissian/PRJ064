<?php

namespace Shared\Tests\Domain\Criteria;

use PHPUnit\Framework\TestCase;
use Shared\Domain\Criteria\Criteria;
use Shared\Domain\Criteria\Filter;
use Shared\Domain\Criteria\FilterCollection;
use Shared\Domain\Criteria\FilterOperator;

class CriteriaTest extends TestCase
{
    /**
     * @test
     */
    public function getFilters_should_filter_by_params() {
        $criteria = new class(
            new FilterCollection([
                new Filter('id', new FilterOperator(FilterOperator::IN), [1,2,3]),
                new Filter('name', new FilterOperator(FilterOperator::EQUAL), 'Toyota'),
            ])
        ) extends Criteria {
            public function getAllowedFields(): array
            {
                return [
                    'id',
                    'name'
                ];
            }
        };

        $this->assertEquals(new FilterCollection([new Filter('id', new FilterOperator(FilterOperator::IN), [1,2,3])]), $criteria->getFilters(['id']));
        $this->assertEquals(new FilterCollection([new Filter('id', new FilterOperator(FilterOperator::IN), [1,2,3])]), $criteria->getFilters(null, [FilterOperator::IN]));
        $this->assertEquals(new FilterCollection([new Filter('id', new FilterOperator(FilterOperator::IN), [1,2,3])]), $criteria->getFilters(['id'], [FilterOperator::IN]));
        $this->assertEquals(new FilterCollection([new Filter('name', new FilterOperator(FilterOperator::EQUAL), 'Toyota')]), $criteria->getFilters(['name']));
        $this->assertEquals(new FilterCollection([new Filter('name', new FilterOperator(FilterOperator::EQUAL), 'Toyota')]), $criteria->getFilters(null, [FilterOperator::EQUAL]));
        $this->assertEquals(new FilterCollection([new Filter('name', new FilterOperator(FilterOperator::EQUAL), 'Toyota')]), $criteria->getFilters(['name'], [FilterOperator::EQUAL]));
    }
}