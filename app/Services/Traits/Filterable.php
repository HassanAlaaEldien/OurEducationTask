<?php

namespace App\Services\Traits;

use App\Services\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;

trait Filterable
{

    /**
     * @param Builder $query
     * @param Filters $filters
     *
     * @return  mixed
     */
    public function scopeFilter(Builder $query, Filters $filters)
    {
        return $filters->apply($query);
    }
}
