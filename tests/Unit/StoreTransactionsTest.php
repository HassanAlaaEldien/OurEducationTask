<?php


use App\Services\Transaction\ProviderAccessor\Accessors\MockingProviders;
use App\Services\Transaction\ProviderAccessor\Contracts\ProviderFileAccessor;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Tests\Traits\ProviderHelper;

class StoreTransactionsTest extends TestCase
{
    use ProviderHelper;

    /**
     * Sends a get request to the list transactions endpoint.
     *
     * @param array $parameters
     * @return TestResponse
     */
    private function hitStoreTransactionsEndpoint($parameters = []): TestResponse
    {
        return $this->post(route('transactions.store', $parameters));
    }

    /**
     * @test
     */
    function a_non_authorized_user_can_store_transactions()
    {
        // At first, we have to clear any old test files then create our providers fake data.
        $this->deleteMockingFiles();
        $this->createProviders(['Transactions.Provider1'], 2);
        $this->createProviders(['Users.Provider1'], 1);

        // We have to mock our data source before hitting our endpoint.
        $this->app->bind(ProviderFileAccessor::class, MockingProviders::class);

        // Then we will hit store transaction endpoint.
        $response = $this->hitStoreTransactionsEndpoint();

        // After that, we have to check that response returns 200.
        $response->assertOk();

        $this->assertDatabaseCount('transactions', 2);
    }
}
