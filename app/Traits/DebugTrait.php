<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait DebugTrait {

    /**
     * Print the SQL query with bindings.
     *
     * @param Builder $query
     * @return string
     */
    static function printQuery(Builder $query) {
        $sql = $query->toSql();
        $bindings = $query->getBindings();

        collect($bindings)->each(function ($binding) use (&$sql) {
            $newBinding = is_string($binding) ? "'" . addslashes($binding) . "'" : $binding;
            $sql = preg_replace('/\?/', $newBinding, $sql, 1);
        });

        return $sql;
    }
}
