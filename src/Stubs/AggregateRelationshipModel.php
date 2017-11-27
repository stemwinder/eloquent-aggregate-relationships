<?php

namespace EloquentAggregateRelationships\Stubs;

use EloquentAggregateRelationships\AggregateRelationshipsTrait;
use Illuminate\Database\Eloquent\Model;

final class AggregateRelationshipModel extends Model
{
    use AggregateRelationshipsTrait;
}
