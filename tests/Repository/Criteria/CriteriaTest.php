<?php

namespace MikroTest\Repository\Criteria;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Criteria;
use Mikro\Repository\Criteria\Filters;
use Mikro\Repository\Criteria\Filter\StringFilter;
use Mikro\Repository\Criteria\Filter\IntFilter;
use Mikro\Repository\Criteria\Filter\BoolFilter;
use Mikro\Repository\Criteria\Filter\DateTimeFilter;
use Mikro\Repository\Criteria\FiltersGroup\AndGroup;
use Mikro\Repository\Criteria\FiltersGroup\OrGroup;
use Mikro\Repository\Criteria\Pagination;
use Mikro\Repository\Criteria\Sorting;
use \DateTime;

class CriteriaTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati paginazione
     */
    public function testCreation()
    {
        $stringFilter = new StringFilter('surname', OPERATOR_STARTS_WITH, 'maff');
        $intFilter = new IntFilter('logins', OPERATOR_GREATER_THAN, 10);
        $boolFilter = new BoolFilter('disabled', OPERATOR_EQUAL, false);
        $andGroup = new OrGroup([$stringFilter, $intFilter, $boolFilter]);
        $stringFilter2 = new StringFilter('name', OPERATOR_STARTS_WITH, 'fe');
        $stringFilter3 = new StringFilter('name', OPERATOR_ENDS_WITH, 'co');
        $orGroup = new OrGroup([$stringFilter2, $stringFilter3]);
        $groupsList = [$andGroup, $orGroup];
        $dateGreaterThan = new DateTimeFilter('lastlogin', OPERATOR_GREATER_THAN_OR_EQUAL, new DateTime('2022-01-01 00:00:01'));
        $dateLessThan = new DateTimeFilter('lastlogin', OPERATOR_LESS_THAN_OR_EQUAL, new DateTime('2022-01-31 23:59:59'));
        $filtersList = [$dateGreaterThan, $dateLessThan];
        $filters = new Filters($filtersList, $groupsList);

        $pagination = new Pagination();
        $sortings = [new Sorting('name'), new Sorting('birthdate', ORDER_DESC)];
        $fields = ['name', 'surname', 'birthdate', 'role.permission.name', 'role.permission.id', 'address.*'];

        $criteria = new Criteria($filters, $pagination, $sortings, $fields);
        $this->assertEquals($filters, $criteria->getFilters());
        $this->assertEquals($pagination, $criteria->getPagination());
        $this->assertEquals($sortings, $criteria->getSortings());
        $this->assertEquals($fields, $criteria->getFields());


        $criteria = new Criteria();
        $this->assertInstanceOf('Mikro\Repository\Criteria\Filters', $criteria->getFilters());
        $this->assertEquals(null, $criteria->getPagination());
        $this->assertEquals([], $criteria->getSortings());
        $this->assertEquals([], $criteria->getFields());
    }
}
