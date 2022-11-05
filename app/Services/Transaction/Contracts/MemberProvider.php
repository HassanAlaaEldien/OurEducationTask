<?php

namespace App\Services\Transaction\Contracts;

interface MemberProvider
{
    /**
     * @return array
     */
    public function transform(string $jsonFilePath): array;
}
