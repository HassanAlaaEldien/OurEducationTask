<?php

namespace App\Services\Filters\Elements;

use App\Services\Filters\Filters;
use Illuminate\Database\Eloquent\Builder;

class MembersFilters extends Filters
{
    /**
     * @param $value
     * @return Builder
     */
    public function statusCode($value): Builder
    {
        return $this->builder->whereHas('transactions', fn($q) => $q->where('status', $value));
    }

    /**
     * @param $value
     * @return Builder
     */
    public function amountMin($value): Builder
    {
        return $this->builder->whereHas('transactions', fn($q) => $q->where('amount', '>=', $value));
    }

    /**
     * @param $value
     * @return Builder
     */
    public function amountMax($value): Builder
    {
        return $this->builder->whereHas('transactions', fn($q) => $q->where('amount', '<=', $value));
    }

    /**
     * @param $value
     * @return Builder
     */
    public function currency($value): Builder
    {
        return $this->builder->whereHas('transactions', fn($q) => $q->where('currency', $value));
    }

    /**
     * @param $value
     * @return Builder
     */
    public function dateFrom($value): Builder
    {
        return $this->builder->whereHas('transactions', fn($q) => $q->whereDate('payment_date', '>=', $value));
    }

    /**
     * @param $value
     * @return Builder
     */
    public function dateTo($value): Builder
    {
        return $this->builder->whereHas('transactions', fn($q) => $q->whereDate('payment_date', '<=', $value));
    }
}
