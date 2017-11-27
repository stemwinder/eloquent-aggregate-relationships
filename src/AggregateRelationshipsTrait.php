<?php namespace EloquentAggregateRelationships;

/**
 * Class AggregateRelationshipsTrait
 * @package EloquentAggregateRelationships
 */
trait AggregateRelationshipsTrait
{

    /**
     * @param string $className
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
     * @param string $className
     * @param string $aggregateType
     *
     * @return string
     */
    public function generateAggregateAlias($className, $aggregateType)
    {
        $className = $this->stripNamespace($className);

        return snake_case($className) . '_' . $aggregateType;
    }

    /**
     * @return string
     */
    public function generateForeignKey()
    {
        $className = get_called_class();
        $className = $this->stripNamespace($className);
        $className = $className . '_id';


        return snake_case($className);
    }

    /**
     * @param string $aggregateType
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
            throw new InvalidAggregateTypeException();
        }
    }

    /**
     * @param string      $aggregateType
     * @param string      $className
     * @param string      $aggregateTargetColumn
     * @param string|null $foreignKey
     *
     * @return mixed
     * @throws InvalidAggregateTypeException
     */
    public function aggregateHasMany($aggregateType, $className, $aggregateTargetColumn, $foreignKey = null)
    {
        $this->validateType($aggregateType);

        $resultAlias = $this->generateAggregateAlias($className, $aggregateType);
        $foreignKey = ($foreignKey) ?: $this->generateForeignKey();

        return $this->hasOne($className)
            ->selectRaw('?, ' . $aggregateType . '(?) as ' . $resultAlias, [$foreignKey, $aggregateTargetColumn])
            ->groupBy($foreignKey);
    }

    /**
     * @param string      $className
     * @param string      $columnToCount
     * @param string|null $foreignKey
     *
     * @return mixed
     */
    public function countHasMany($className, $columnToCount = '*', $foreignKey = null)
    {
        return $this->aggregateHasMany('count', $className, $columnToCount, $foreignKey);
    }

    /**
     * @param string      $className
     * @param string      $columnToAverage
     * @param string|null $foreignKey
     *
     * @return mixed
     */
    protected function averageHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('avg', $className, $columnToAverage, $foreignKey);
    }

    /**
     * @param string $className
     * @param string $columnToAverage
     * @param null   $foreignKey
     *
     * @return mixed
     */
    protected function minHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('min', $className, $columnToAverage, $foreignKey);
    }

    /**
     * @param string $className
     * @param string $columnToAverage
     * @param null   $foreignKey
     *
     * @return mixed
     */
    protected function maxHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('max', $className, $columnToAverage, $foreignKey);
    }

    /**
     * @param string $className
     * @param string $columnToAverage
     * @param null   $foreignKey
     *
     * @return mixed
     */
    protected function sumHasMany($className, $columnToAverage, $foreignKey = null)
    {
        return $this->aggregateHasMany('sum', $className, $columnToAverage, $foreignKey);
    }

}
