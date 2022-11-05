<?php

namespace App\Services\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * Filters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Applies filters to the Query Builder
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter) && $value)
                call_user_func([$this, $filter], $value);
        }

        return $this->builder;
    }

    /**
     * Gets the filters from the request inputs.
     *
     * @return  array
     */
    public function filters()
    {
        return $this->request->all();
    }
}
