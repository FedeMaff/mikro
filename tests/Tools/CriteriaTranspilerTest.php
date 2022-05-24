<?php

namespace MikroTest\Tools;
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

use PHPUnit\Framework\TestCase;
use Mikro\Tools\CriteriaTranspiler;
use MikroTest\Assets\Classes\FakeEntityProduct;
use MikroTest\Assets\Classes\FakeEntityPost;

class CriteriaTranspilerTest extends TestCase
{
    public function testVariadicReadonly()
    {
        $array[FILTERS_KEY]['id'][OPERATOR_EQUAL] = 1;
        $array[FILTERS_KEY]['user']['name'][OPERATOR_EQUAL] = "ciao";
        $array[FIELDS_KEY]['user']['name'] = null;
        $criteria = CriteriaTranspiler::transpile($array, new FakeEntityPost);
        $this->assertInstanceOf('Mikro\Repository\Criteria\CriteriaInterface', $criteria);

        $filters = $criteria->getFilters()->getFilters();
        $this->assertEquals(1, count($filters));
        $this->assertInstanceOf('Mikro\Repository\Criteria\Filter\IntFilter', reset($filters));

        $fields = $criteria->getFields();
        $this->assertEquals(1, count($fields));
        $this->assertEquals(['name' => []], $fields['fakeEntityUser']);
    }

    /**
     * Verifica creazione istanza criteri con filtri
     */
    public function testFilters()
    {
        $array[FILTERS_KEY]['category']['name'][OPERATOR_EQUAL] = 'tecnologia';
        $array[FILTERS_KEY]['price'][OPERATOR_LESS_THAN] = 10;
        $array[FILTERS_KEY]['name'][OPERATOR_STARTS_WITH] = 'ipho';
        $array[FILTERS_KEY]['shops']['address']['province'][OPERATOR_STARTS_WITH] = 'to';
        $array[FILTERS_KEY]['shops']['address']['city'][OPERATOR_ENDS_WITH] = 'asca';
        $array[FILTERS_KEY]['shops']['address']['number'][OPERATOR_IS_NOT_NULL] = null;
        $array[FILTERS_KEY]['shops']['address']['zipCode'][OPERATOR_IS_NULL] = null;
        $array[FILTERS_KEY][OPERATOR_OR]['shops']['address']['province'][OPERATOR_EQUAL] = 'TO';
        $array[FILTERS_KEY][OPERATOR_OR]['shops']['revenue'][OPERATOR_GREATER_THAN_OR_EQUAL] = 1230;
        $array[FILTERS_KEY][OPERATOR_OR][OPERATOR_AND]['shops']['revenue'][OPERATOR_LESS_THAN] = 1000;
        $array[FILTERS_KEY][OPERATOR_OR][OPERATOR_AND]['shops']['revenue'][OPERATOR_IN] = [1000,2000];
        $array[FILTERS_KEY][OPERATOR_OR][OPERATOR_AND]['shops']['address']['city'][OPERATOR_EQUAL] = "INVERSO PINASCA";
        $array[FILTERS_KEY][OPERATOR_OR][OPERATOR_AND]['shops']['address']['zipcode'][OPERATOR_IS_NOT_NULL] = null;

        # Questo filtro è sbagliato ( OPERATOR_ENDS_WITH ) è per campi stringa
        $array[FILTERS_KEY]['category']['color']['id'][OPERATOR_ENDS_WITH] = '-1';
        # Questo filtro deve essere ignorato perchè non esiste il field road dentro address
        $array[FILTERS_KEY]['shops']['address']['road'][OPERATOR_STARTS_WITH] = 'pi';
        # Questo filtro deve essere ignorato perchè non esiste il field road dentro address
        $array[FILTERS_KEY]['slug'][OPERATOR_EQUAL] = 'prova';
        

        $criteria = CriteriaTranspiler::transpile($array, new FakeEntityProduct);
        $filters = $criteria->getFilters()->getFilters();
        $groups = $criteria->getFilters()->getFiltersGroups();

        $this->assertEquals(7, count($filters));
        $this->assertEquals(1, count($groups));

        $filter = $filters[0];
        $this->assertEquals('fakeEntityCategory.name', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals('tecnologia', $filter->getValue());
        $filter = $filters[1];
        $this->assertEquals('price', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN, $filter->getOperator());
        $this->assertEquals(10, $filter->getValue());
        $filter = $filters[2];
        $this->assertEquals('name', $filter->getField());
        $this->assertEquals(OPERATOR_STARTS_WITH, $filter->getOperator());
        $this->assertEquals('ipho', $filter->getValue());
        $filter = $filters[3];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.province', $filter->getField());
        $this->assertEquals(OPERATOR_STARTS_WITH, $filter->getOperator());
        $this->assertEquals('to', $filter->getValue());
        $filter = $filters[4];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.city', $filter->getField());
        $this->assertEquals(OPERATOR_ENDS_WITH, $filter->getOperator());
        $this->assertEquals('asca', $filter->getValue());
        $filter = $filters[5];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.number', $filter->getField());
        $this->assertEquals(OPERATOR_IS_NOT_NULL, $filter->getOperator());
        $filter = $filters[6];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.zipCode', $filter->getField());
        $this->assertEquals(OPERATOR_IS_NULL, $filter->getOperator());

        $group = $groups[0];
        $filters = $group->getFilters();
        $groups = $group->getFiltersGroups();

        $filter = $filters[0];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.province', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals('TO', $filter->getValue());
        $filter = $filters[1];
        $this->assertEquals('fakeEntityShop.revenue', $filter->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN_OR_EQUAL, $filter->getOperator());
        $this->assertEquals(1230, $filter->getValue());

        $group = $groups[0];
        $filters = $group->getFilters();

        $filter = $filters[0];
        $this->assertEquals('fakeEntityShop.revenue', $filter->getField());
        $this->assertEquals(OPERATOR_LESS_THAN, $filter->getOperator());
        $this->assertEquals(1000, $filter->getValue());
        $filter = $filters[1];
        $this->assertEquals('fakeEntityShop.revenue', $filter->getField());
        $this->assertEquals(OPERATOR_IN, $filter->getOperator());
        $this->assertEquals(["1000", "2000"], $filter->getValue());
        $filter = $filters[2];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.city', $filter->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter->getOperator());
        $this->assertEquals('INVERSO PINASCA', $filter->getValue());
        $filter = $filters[3];
        $this->assertEquals('fakeEntityShop.fakeEntityAddress.zipCode', $filter->getField());
        $this->assertEquals(OPERATOR_IS_NOT_NULL, $filter->getOperator());
        
        // $array[PAGINATION_KEY][PAGINATION_PAGE_KEY] = 2;
        // $array[PAGINATION_KEY][PAGINATION_LIMIT_KEY] = 100;

        // $array[SORTINGS_KEY]['price'] = ORDER_DESC;
        // $array[SORTINGS_KEY]['category']['color']['id'] = ORDER_DESC;
        // $array[SORTINGS_KEY]['shops']['address']['zipcode'] = ORDER_ASC;

        // $array[FIELDS_KEY]['id'] = null;
        // $array[FIELDS_KEY]['name'] = null;
        // $array[FIELDS_KEY]['price'] = null;
        // $array[FIELDS_KEY]['category']['name'] = null;
        // $array[FIELDS_KEY]['shops']['address']['city'] = null;
        // $array[FIELDS_KEY]['shops']['address']['province'] = null;
        // $array[FIELDS_KEY]['shops']['address']['piazza'] = null;

        $test2[FILTERS_KEY][OPERATOR_OR][]['name'][OPERATOR_EQUAL] = 'gabriele';
        $test2[FILTERS_KEY][OPERATOR_OR][]['name'][OPERATOR_EQUAL] = 'federico';
        $criteria = CriteriaTranspiler::transpile($test2, new FakeEntityProduct);
        $groups = $criteria->getFilters()->getFiltersGroups();
        $orGroup = $groups[0];
        $filter1 = $orGroup->getFilters()[0];
        $filter2 = $orGroup->getFilters()[1];

        $this->assertEquals('name', $filter1->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter1->getOperator());
        $this->assertEquals('gabriele', $filter1->getValue());

        $this->assertEquals('name', $filter2->getField());
        $this->assertEquals(OPERATOR_EQUAL, $filter2->getOperator());
        $this->assertEquals('federico', $filter2->getValue());

        $test3[FILTERS_KEY][OPERATOR_AND][]['shops']['n'][OPERATOR_GREATER_THAN_OR_EQUAL] = 20;
        $test3[FILTERS_KEY][OPERATOR_AND][]['shops']['n'][OPERATOR_LESS_THAN_OR_EQUAL] = 100;
        $criteria = CriteriaTranspiler::transpile($test3, new FakeEntityProduct);
        $groups = $criteria->getFilters()->getFiltersGroups();
        $andGroup = $groups[0];
        $filter1 = $andGroup->getFilters()[0];
        $filter2 = $andGroup->getFilters()[1];

        $this->assertEquals('fakeEntityShop.n', $filter1->getField());
        $this->assertEquals(OPERATOR_GREATER_THAN_OR_EQUAL, $filter1->getOperator());
        $this->assertEquals(20, $filter1->getValue());

        $this->assertEquals('fakeEntityShop.n', $filter2->getField());
        $this->assertEquals(OPERATOR_LESS_THAN_OR_EQUAL, $filter2->getOperator());
        $this->assertEquals(100, $filter2->getValue());
    }
}
