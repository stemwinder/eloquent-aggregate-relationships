<?php namespace AndyFleming\EloquentAggregateRelationships;

use Illuminate\Database\Query\Builder;

trait AggregateRelationshipsTrait
{

    private function stripNamespace($className)
    {
        if (strpos($className, '\\') !== false) {
            $parts = explode('\\', $className);
            $className = end($parts);
        }

        return $className;
    }

    public function generateAggregateAlias($className, $aggregateType)
    {
        $className = $this->stripNamespace($className);

        return snake_case($className) . '_' . $aggregateType;
    }

    public function generateForeignKey()
    {
        $className = get_called_class();
        $className = $this->stripNamespace($className);
        $className = $className.'_id';


        return snake_case($className);
    }

    public function validateType($aggregateType)
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

    private function aggregateHasMany($aggregateType, $className, $foreignKey = null, $resultAlias = null, $aggregateTargetColumn)
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
     * @param null   $foreignKey
     * @param null   $countFieldName
     * @param string $columnToCount - The column you want to count the distinct values in
     *
     * @return mixed
     */
    protected function countHasMany($className, $columnToCount = '*', $foreignKey = null, $countFieldName = null)
    {

        return $this->aggregateHasMany('count', $className, $foreignKey, $countFieldName, $columnToCount);

    }

    protected function averageHasMany($className, $columnToAverage, $foreignKey = null, $countFieldName = null)
    {
        return $this->aggregateHasMany('avg', $className, $foreignKey, $countFieldName, $columnToAverage);
    }

    // min()

    // max()

    // sum()


}