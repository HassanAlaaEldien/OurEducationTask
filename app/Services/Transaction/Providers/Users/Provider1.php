<?php

namespace App\Services\Transaction\Providers\Users;

use App\Services\Transaction\Contracts\MemberProvider;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Provider1 implements MemberProvider
{
    /**
     * @param string $jsonFilePath
     * @return array
     */
    public function transform(string $jsonFilePath): array
    {
        $fileContent = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath)) : [];

        return Collection::make($fileContent->users ?? [])->map(function ($item) {
            $created_at = explode('/', $item->created_at);
            $created_at = count($created_at) === 3
                ? Carbon::create($created_at[2], $created_at[1], $created_at[0])
                : null;
            return [
                'uuid' => $item->id,
                'balance' => $item->balance,
                'currency' => $item->currency,
                'email' => $item->email,
                'created_at' => $created_at
            ];
        })->toArray();
    }
}
