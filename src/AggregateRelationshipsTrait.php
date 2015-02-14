<?php namespace AndyFleming\EloquentAggregateRelationships;

trait AggregateRelationshipsTrait
{

    /**
     * @param $className
     *
     * @return mixed
     */
    private function stripNamespace($className)
    {
        if (strpos($className, '\\') !== false) {
            $parts = explode('\\', $className);
            $className = end($parts);
        }

        return $className;
    }

    /**
     * @param $className
     * @param $aggregateType
     *
     * @return string
     */
    private function generateAggregateAlias($className, $aggregateType)
    {
        $className = $this->stripNamespace($className);

        return snake_case($className) . '_' . $aggregateType;
    }

    /**
     * @return string
     */
    private function generateForeignKey()
    {
        $className = get_called_class();
        $className = $this->stripNamespace($className);
        $className = $className.'_id';


        return snake_case($className);
    }

    /**
     * @param $aggregateType
     *
     * @throws InvalidAggregateTypeException
     */
    private function validateType($aggregateType)
    {
        $validTypes = [
            'avg',
            'count',
            'sum',
            'min',
            'max',
        ];

        if (!in_array($aggregateType, $validTypes)) {
            throw new InvalidAggregateTypeException('');
        }
    }

    /**
     * @param      $aggregateType
     * @param      $className
     * @param      $aggregateTargetColumn
     * @param null $foreignKey
     *
     * @return mixed
     * @throws InvalidAggregateTypeException
     */
    private function aggregateHasMany($aggregateType, $className, $aggregateTargetColumn, $foreignKey = null)
    {
        $this->validateType($aggregateType);

        $resultAlias = $this->generateAggregateAlias($className, $aggregateType);
        $foreignKey = ($foreignKey) ?: $this->generateForeignKey();

        return $this->hasOne($className)
            ->selectRaw('?, ' . $aggregateType . '(?) as '.$resultAlias,[$foreignKey, $aggregateTargetColumn])
            ->groupBy($foreignKey);
    }

    /**
     * @param        $className
     * @param string $columnToCount
     * @param null   $foreignKey
     *
     * @return mixed
     */
    protected function countHasMany($className, $columnToCount = '*', $foreignKey = null)
    {
        return $this->aggregateHasMany('count', $className, $columnToCount, $foreignKey);
    }

    /**
     * @param      $className
     * @param      $columnToAverage
     * @param null $foreignKey
     *
     * @return mixed
     */
    protected function averageHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('avg', $className, $columnToAverage, $foreignKey);
    }

    /**
     * @param      $className
     * @param      $columnToAverage
     * @param null $foreignKey
     *
     * @return mixed
     */
    protected function minHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('min', $className, $columnToAverage, $foreignKey);
    }

    /**
     * @param      $className
     * @param      $columnToAverage
     * @param null $foreignKey
     *
     * @return mixed
     */
    protected function maxHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('max', $className, $columnToAverage, $foreignKey);
    }

    /**
     * @param      $className
     * @param      $columnToAverage
     * @param null $foreignKey
     *
     * @return mixed
     */
    protected function sumHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('sum', $className, $columnToAverage, $foreignKey);
    }

}