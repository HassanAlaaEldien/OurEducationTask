<?php

namespace App\Services\Transaction\ProviderAccessor\Accessors;

use App\Services\Transaction\ProviderAccessor\Contracts\ProviderFileAccessor;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class LiveProviders implements ProviderFileAccessor
{
    /**
     * @return Collection
     */
    public function getProviders(array $customProviders = []): Collection
    {
        foreach (self::PROVIDER_TYPES as $type) {
            $providers[$type] = $this->getJsonFilePaths($type);
        }

        return Collection::make($providers)
            ->filter(fn($file, $path) => empty($customProviders) || in_array($file['name'], $customProviders));
    }

    /**
     * @param string $path
     * @param string $type
     * @return mixed
     */
    private function getJsonFilePaths(string $type)
    {
        $path = base_path("app/Services/Transaction/Providers/{$type}");

        Collection::make(array_diff(scandir($path), array('.', '..', 'Mocking')))
            ->each(function ($file) use (&$providers, $type) {

                $fileName = Str::remove('.php', $file);
                $providers["App\\Services\\Transaction\\Providers\\{$type}\\{$fileName}"] = [
                    'name' => $fileName,
                    'path' => storage_path("LiveProviders/{$type}/{$fileName}.json")
                ];
            });

        return $providers;
    }
}
