<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class AggregateRelationshipsTraitTest extends FunctionalTestCase
{
    public function setUp()
    {
        parent::setUp();
        Eloquent::unguard();
    }

    public function test_trueIsTrue()
    {
        $this->assertTrue(true);
    }

    public function test_instantiation_of_model_stub()
    {
        $testObj = new AggregateRelationshipModelStub();

        $this->assertInstanceOf('AggregateRelationshipModelStub', $testObj);
    }

    public function test_instantiation_of_mock()
    {
        $mock = $this->getMockForTrait('AndyFleming\EloquentAggregateRelationships\AggregateRelationshipsTrait');

//        $mock->expects($this->any())
//            ->method('countHasMany')
//            ->willReturn($this->returnValue(true));

        //$this->assertTrue($mock->concreteMethod());

    }
}
