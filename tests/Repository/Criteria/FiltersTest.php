<?php

namespace MikroTest\Repository\Criteria;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\Filters;
use Mikro\Repository\Criteria\Filter\StringFilter;
use Mikro\Repository\Criteria\Filter\IntFilter;
use Mikro\Repository\Criteria\Filter\BoolFilter;
use Mikro\Repository\Criteria\Filter\DateTimeFilter;
use Mikro\Repository\Criteria\FiltersGroup\AndGroup;
use Mikro\Repository\Criteria\FiltersGroup\OrGroup;
use \DateTime;

class FiltersTest extends TestCase
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

        $this->assertCount(2, $filters->getFiltersGroups());
        $this->assertEquals($groupsList, $filters->getFiltersGroups());
        $this->assertCount(2, $filters->getFilters());
        $this->assertEquals($filtersList, $filters->getFilters());
    }
}
