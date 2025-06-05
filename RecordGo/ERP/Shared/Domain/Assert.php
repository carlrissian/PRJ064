<?php

namespace Shared\Domain;

use InvalidArgumentException;

final class Assert
{
    /**
     * @param string $class
     * @param array $items
     */
    public static function arrayOf(string $class, array $items): void
    {
        foreach ($items as $item) {
            self::instanceOf($class, $item);
        }
    }

    /**
     * @param $class
     * @param $item
     */
    public static function instanceOf($class, $item): void
    {
        if (!$item instanceof $class) {
            throw new InvalidArgumentException(
                sprintf('The object <%s> is not an instance of <%s>', $class, get_class($item))
            );
        }
    }

    /**
     * @param $type
     * @param $models
     * @return array
     */
    public static  function getIdsArrayProperty($type, $models): array
    {
        $arrayIds = [];
        foreach ($models as $model) {
            $arrayIds = (sizeof($arrayIds) === 0) ? $model->$type() : array_merge($arrayIds, $model->$type());
        }
        return array_values(array_unique($arrayIds));
    }

    /**
     * @param $type
     * @param $models
     * @return array
     */
    public static function getIdsProperty($type, $models): array
    {
        $ids = array_map(static function ($model) use ($type) {
            return $model->$type();
        }, $models);
        return array_unique($ids);
    }

    /**
     * @param $type
     * @param $models
     * @return array
     */
    public static function getIdsPropertyArray($type, $models): array
    {
        $ids = array_map(static function ($model) use ($type) {
            return $model[$type];
        }, $models);
        return array_unique($ids);
    }

    /**
     * @param $type
     * @param $model
     * @return array
     */
    public static function getIdProperty($type, $model): array
    {
        return [$model->$type()];
    }
}
