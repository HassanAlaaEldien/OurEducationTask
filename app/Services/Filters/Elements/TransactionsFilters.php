<?php

namespace App\Services\Filters\Elements;

use App\Services\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;

class TransactionsFilters extends Filters
{
    /**
     * @param $value
     * @return Builder
     */
    public function statusCode($value): Builder
    {
        return $this->builder->where('status', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function amountMin($value): Builder
    {
        return $this->builder->where('amount', '>=', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function amountMax($value): Builder
    {
        return $this->builder->where('amount', '<=', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function currency($value): Builder
    {
        return $this->builder->where('currency', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function dateFrom($value): Builder
    {
        return $this->builder->whereDate('payment_date', '>=', $value);
    }

    /**
     * @param $value
     * @return Builder
     */
    public function dateTo($value): Builder
    {
        return $this->builder->whereDate('payment_date', '<=', $value);
    }
}
