<?php

namespace spec\AndyFleming\EloquentAggregateRelationships;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AggregateRelationshipsTraitSpec extends ObjectBehavior
{

    function let()
    {
        $this->beAnInstanceOf('AndyFleming\EloquentAggregateRelationships\Stubs\AggregateRelationshipModel');
    }

    public function it_should_return_snaked_case_name_with_aggregate_type()
    {
        $this->generateAggregateAlias('ArticleComment','count')->shouldReturn('article_comment_count');
    }

    public function it_should_return_snaked_case_name_without_namespace_with_aggregate_type()
    {
        $this->generateAggregateAlias('Blog\ArticleComment','count')->shouldReturn('article_comment_count');
    }

}
