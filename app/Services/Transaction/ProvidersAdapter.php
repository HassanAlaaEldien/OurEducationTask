<?php

namespace App\Services\Transaction;

use App\Models\Member;
use App\Models\Transaction;
use App\Services\Transaction\ProviderAccessor\Contracts\ProviderFileAccessor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

class ProvidersAdapter
{
    /**
     * @var Collection
     */
    private Collection $providers;

    /**
     * @param ProviderFileAccessor $providerFileAccessor
     * @param array $providers
     */
    public function __construct(ProviderFileAccessor $providerFileAccessor, array $providers = [])
    {
        $this->providers = $providerFileAccessor->getProviders(array_filter($providers));
    }

    /**
     * @return void
     */
    public function storeProvidersData(): void
    {
        $this->providers->each(function ($providers, $type) use (&$users, &$transactions) {
            foreach ($providers as $path => $provider) {
                $transformedData = App::make($path)->transform($provider['path']);
                match ($type) {
                    'Users' => $this->saveUsers($transformedData),
                    'Transactions' => $this->saveTransactions($transformedData),
                };
            }
        });
    }

    /**
     * @param array $transactions
     * @return void
     */
    private function saveTransactions(array $transactions): void
    {
        $emails = Collection::make($transactions)->pluck('member_id')->toArray();
        $members = Member::whereIn('email', $emails)->get();
        foreach ($transactions as $transaction){
            $transaction['member_id'] = $members->where('email', $transaction['member_id'])->first()?->uuid;
            Transaction::create($transaction);
        }
    }

    /**
     * @param array $users
     * @return void
     */
    private function saveUsers(array $users): void
    {
        foreach ($users as $user)
            Member::firstOrCreate(['email' => $user['email']], $user);
    }
}
