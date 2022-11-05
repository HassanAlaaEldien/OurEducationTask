<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ResponsesInterface;
use App\Models\Member;
use App\Providers\APIServiceProvider;
use App\Services\Filters\Elements\MembersFilters;
use App\Transformers\CustomDataSerializer;
use App\Transformers\MembersTransformer;
use Illuminate\Http\JsonResponse;
use Spatie\Fractal\Fractal;

class MembersController extends Controller
{
    /**
     * @var ResponsesInterface $responder
     */
    protected ResponsesInterface $responder;

    /**
     * @param ResponsesInterface $responder
     */
    public function __construct(ResponsesInterface $responder)
    {
        $this->responder = $responder;
    }

    /**
     * Handle the request for listing/filtering members.
     *
     * @param MembersFilters $membersFilters
     * @return JsonResponse
     */
    public function index(MembersFilters $membersFilters): JsonResponse
    {
        $members = Member::filter($membersFilters)->paginate(APIServiceProvider::ItemsPerPage);

        $transformedMembers = Fractal::create(
            $members->items(), new MembersTransformer(), CustomDataSerializer::class
        )->withResourceName('data')->toArray();

        return $this->responder->respondWithPagination($members, $transformedMembers);
    }
}
