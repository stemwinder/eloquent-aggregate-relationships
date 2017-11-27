<?php

namespace spec\EloquentAggregateRelationships;

use Illuminate\Database\Capsule\Manager as DB;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class AggregateRelationshipsTraitSpec extends ObjectBehavior
{

    function setupEloquentConnection()
    {
        $db = new DB;
        $db->addConnection(array(
            'driver'    => 'sqlite',
            'database'  => ':memory:',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ));
        $db->bootEloquent();
        $db->setAsGlobal();

    }

    function let()
    {
        $this->beAnInstanceOf('EloquentAggregateRelationships\Stubs\AggregateRelationshipModel');
    }

    public function it_should_return_snaked_case_name_with_aggregate_type()
    {
        $this->generateAggregateAlias('ArticleComment', 'count')->shouldReturn('article_comment_count');
    }

    public function it_should_return_snaked_case_name_without_namespace_with_aggregate_type()
    {
        $this->generateAggregateAlias('Blog\ArticleComment', 'count')->shouldReturn('article_comment_count');
    }

    /*
    public function it_should_throw_an_exception_if_the_type_is_unsupported()
    {
        //$this->setupEloquentConnection();

        //$this->shouldThrow('EloquentAggregateRelationships\InvalidAggregateTypeException()');
        //$this->aggregateHasMany('badtype', 'Class', '*');
    }

    public function it_should_return_an_accurate_count()
    {
        //$this->countHasMany('Class', '*')->shouldReturn(true);
    }
    */

}
