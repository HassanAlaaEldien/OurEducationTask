<?php

namespace App\Services\Transaction\ProviderAccessor\Contracts;

use Illuminate\Support\Collection;

interface ProviderFileAccessor
{
    /**
     * Define Provider Types such as ( Transactions || Users )
     * Order here matters, for example we have to import users before it's transactions
     * So we have to set Users at first of array before transactions and so on ...
     */
    public const PROVIDER_TYPES = ['Users', 'Transactions'];

    /**
     * @return Collection
     */
    public function getProviders(array $customProviders = []): Collection;
}
