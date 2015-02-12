<?php namespace AndyFleming\EloquentAggregateRelationships;

trait AggregateRelationshipsTrait {

    public function generateAggregateAlias($className, $aggregateType)
    {
        if (strpos($className,'\\') !== false) {
            $className = end(explode('\\',$className));
        }

        return snake_case($className).'_'.$aggregateType;
    }

    private function aggregateHasMany($aggregateType, $className, $foreignKey=null, $resultAlias=null, $aggregateTargetColumn)
    {
        $resultAlias = ($resultAlias)?: $this->generateAggregateAlias($className, $aggregateType);

        if (!$foreignKey) {
            $foreignKey = snake_case(get_called_class());
        }

        return $this->hasOne($className)
            ->selectRaw(':foreign_key, count('.$aggregateTargetColumn.') as :aggregate_result_column_name',
                [
                    'foreign_key' => $foreignKey,
                    'aggregate_result_column_name' => $resultAlias
                ]
            )
            ->groupBy($foreignKey);
    }

    /**
     * @param      $className - example - Comment
     * @param null $foreignKey - example "article_id"
     * @param null $countFieldName - example "comments_count"
     *
     * @return mixed
     */
    protected function countHasMany($className, $foreignKey=null, $countFieldName=null)
    {

        return $this->aggregateHasMany('count', $className, $foreignKey, $countFieldName, '*');

    }

    protected function averageHasMany()
    {
        // avg()
    }

    // min()

    // max()

    // sum()


}