<?php

namespace App\Services\Transaction\Providers\Transactions;

use App\Services\Transaction\Contracts\TransactionProvider;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Provider1 implements TransactionProvider
{
    /**
     * @param string $jsonFilePath
     * @return array
     */
    public function transform(string $jsonFilePath): array
    {
        $fileContent = file_exists($jsonFilePath) ? json_decode(file_get_contents($jsonFilePath)) : [];

        return Collection::make($fileContent->transactions ?? [])->map(function ($item) {
            return [
                'amount' => $item->paidAmount,
                'currency' => $item->Currency,
                "member_id" => $item->parentEmail,
                "status" => $this->statusMapper($item->statusCode),
                "payment_date" => Carbon::parse($item->paymentDate),
                "parent_id" => $item->parentIdentification
            ];
        })->toArray();
    }

    /**
     * @param $status
     * @return string
     */
    public function statusMapper($status): string
    {
        return match ($status) {
            '1', 1 => 1,
            '2', 2 => 2,
            '3', 3 => 3
        };
    }
}
