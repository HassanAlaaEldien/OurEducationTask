<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponsesInterface;
use App\Models\Transaction;
use App\Providers\APIServiceProvider;
use App\Services\Filters\Elements\TransactionsFilters;
use App\Services\Transaction\ProviderAccessor\Contracts\ProviderFileAccessor;
use App\Services\Transaction\ProvidersAdapter;
use App\Transformers\CustomDataSerializer;
use App\Transformers\TransactionsTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Fractal\Fractal;

class TransactionsController extends Controller
{
    /**
     * @var ResponsesInterface $responder
     */
    protected ResponsesInterface $responder;

    /**
     * @var ProviderFileAccessor $providerAccessor
     */
    protected ProviderFileAccessor $providerAccessor;

    /**
     * @param ResponsesInterface $responder
     */
    public function __construct(ResponsesInterface $responder, ProviderFileAccessor $providerFileAccessor)
    {
        $this->responder = $responder;
        $this->providerAccessor = $providerFileAccessor;
    }

    /**
     * Handle the request for listing/filtering transactions.
     *
     * @param TransactionsFilters $transactionsFilters
     * @return JsonResponse
     */
    public function index(TransactionsFilters $transactionsFilters): JsonResponse
    {
        $transactions = Transaction::filter($transactionsFilters)->paginate(APIServiceProvider::ItemsPerPage);

        $transformedTransactions = Fractal::create(
            $transactions->items(), new TransactionsTransformer(), CustomDataSerializer::class
        )->withResourceName('data')->toArray();

        return $this->responder->respondWithPagination($transactions, $transformedTransactions);
    }

    /**
     * Handle the request for storing transactions and users from providers.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $providerAdapter = new ProvidersAdapter($this->providerAccessor);

        $providerAdapter->storeProvidersData();

        return $this->responder->respond(['data' => ['message' => 'Transactions/Users data has been stored successfully.']]);
    }
}
