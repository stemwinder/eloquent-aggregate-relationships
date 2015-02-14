<?php

namespace AndyFleming\EloquentAggregateRelationships\Stubs;

use AndyFleming\EloquentAggregateRelationships\AggregateRelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

final class AggregateRelationshipModel extends Model
{
    use AggregateRelationshipsTrait;
}
