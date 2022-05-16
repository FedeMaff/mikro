<?php

namespace MikroTest\Repository\Criteria\FiltersGroup;

use PHPUnit\Framework\TestCase;
use Mikro\Repository\Criteria\FiltersGroup\OrGroup;
use Mikro\Repository\Criteria\Filter\StringFilter;
use Mikro\Repository\Criteria\Filter\IntFilter;
use Mikro\Repository\Criteria\Filter\BoolFilter;

class OrGroupTest extends TestCase
{
    /**
     * Verifica corretta creazione e recupero dati ordinamento
     */
    public function testCreation()
    {
        $stringFilter = new StringFilter('surname', OPERATOR_STARTS_WITH, 'maff');
        $intFilter = new IntFilter('logins', OPERATOR_GREATER_THAN, 10);
        $boolFilter = new BoolFilter('disabled', OPERATOR_EQUAL, false);

        $group = new OrGroup([$stringFilter, $intFilter, $boolFilter]);
        $this->assertCount(3, $group->getFilters());
        $this->assertEquals([$stringFilter, $intFilter, $boolFilter], $group->getFilters());
        
        $group = new OrGroup();
        $group->addFilter($stringFilter);
        $group->addFilter($intFilter);
        $group->addFilter($boolFilter);
        $this->assertCount(3, $group->getFilters());
        $this->assertEquals([$stringFilter, $intFilter, $boolFilter], $group->getFilters());
        
        $group = new OrGroup([$stringFilter, $intFilter]);
        $group->addFilter($boolFilter);
        $this->assertCount(3, $group->getFilters());
        $this->assertEquals([$stringFilter, $intFilter, $boolFilter], $group->getFilters());
        
    }
}
