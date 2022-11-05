<?php

namespace Tests\Traits;

use Carbon\Carbon;
use Faker\Factory;

trait ProviderHelper
{
    /**
     * @param $providers
     * @param $itemsPerProvider
     * @param array $amountRange
     * @param null $status
     * @param null $currency
     * @return void
     */
    private function createProviders($providers, $itemsPerProvider, $amountRange = [], $status = null, $currency = null)
    {
        foreach ($providers as $provider) {
            $provider = explode('.', $provider);
            $jsonFile = fopen(storage_path("mockingFiles/{$provider[0]}/{$provider[1]}.json"), "w");
            fwrite(
                $jsonFile,
                $this->getJsonFileContent($itemsPerProvider, $amountRange, $currency, $status, $provider[0])
            );
            fclose($jsonFile);
        }
    }

    /**
     * @return void
     */
    private function deleteMockingFiles(): void
    {
        // Delete all old testing files.
        $files = glob(storage_path("mockingFiles/Transactions/*")) + glob(storage_path("mockingFiles/Users/*"));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        // Then, Create Mocking Folder If It Doesn't Exist.
        if (!file_exists(storage_path("mockingFiles"))) {
            mkdir(storage_path("mockingFiles/Transactions"), 0777, true);
            mkdir(storage_path("mockingFiles/Users"), 0777, true);
        }
    }

    /**
     * @param array $amountRange
     * @param mixed $currency
     * @param mixed $status
     * @return array[]
     */
    private function getProvidersFileStructure(array $amountRange, mixed $currency, mixed $status): array
    {
        $faker = Factory::create();

        $providersStructure = [
            'Transactions' => [
                "paidAmount" => $faker->randomElement($amountRange ?: range(10, 100)),
                "Currency" => ($currency ?: $faker->currencyCode()),
                "parentEmail" => $faker->email(),
                "phone" => $faker->phoneNumber(),
                "statusCode" => ($status ?: $faker->randomElement([1, 2, 3])),
                "paymentDate" => $faker->date,
                "parentIdentification" => $faker->uuid()
            ],
            'Users' => [
                "balance" => $faker->randomElement($amountRange ?: range(10, 100)),
                "currency" => ($currency ?: $faker->currencyCode()),
                "email" => $faker->email(),
                "created_at" => $faker->date('d/m/Y'),
                "id" => $faker->uuid()
            ]
        ];

        return $providersStructure;
    }

    /**
     * @param $itemsPerProvider
     * @param array $amountRange
     * @param mixed $currency
     * @param mixed $status
     * @param string $provider
     * @return string
     */
    private function getJsonFileContent($itemsPerProvider, array $amountRange, mixed $currency, mixed $status, string $provider): string
    {
        $content = '{"' . lcfirst($provider) . '": [';
        for ($item = 0; $item < $itemsPerProvider; $item++) {
            $content .= json_encode(
                    $this->getProvidersFileStructure($amountRange, $currency, $status)[$provider],
                    JSON_UNESCAPED_SLASHES
                ) . ($item + 1 == $itemsPerProvider ? '' : ',');
        }
        $content .= ']}';
        return $content;
    }
}
