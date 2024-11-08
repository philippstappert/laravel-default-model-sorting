<?php

namespace Stephenjude\DefaultModelSorting\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DefaultOrderBy
{
    protected static function bootDefaultOrderBy()
    {
        if (empty(self::$orderByColumn) && empty(self::$orderByRawColumn)) {
            return;
        }

        $column = isset(self::$orderByColumn) ? self::$orderByColumn : null;
        $rawColumn = isset(self::$orderByRawColumn) ? self::$orderByRawColumn : null;

        $direction = isset(self::$orderByColumnDirection)
            ? self::$orderByColumnDirection
            : config('default-model-sorting.order_by');

        static::addGlobalScope('default_order_by', function (Builder $builder) use ($column, $rawColumn, $direction) {
            if (!empty($rawColumn)) {
                $builder->orderByRaw($rawColumn);
            } else {
                $builder->orderBy($column, $direction);
            }
        });
    }
}
