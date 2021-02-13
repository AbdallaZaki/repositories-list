<?php

namespace App\Http\Controllers\Api\V1\RepositoriesService;

use App\Http\Controllers\Controller;
use App\Http\Requests\FilterRepositoriesRequest;
use App\Http\Resources\RepositoryResource;
use App\Services\GithuhServices\Contracts\SearchServiceInterface;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SearchController extends Controller
{
    /**
     * @param FilterRepositoriesRequest $request
     * @param SearchServiceInterface $searchService
     * @return ResourceCollection
     */
    public function index(FilterRepositoriesRequest $request,SearchServiceInterface $searchService):ResourceCollection
    {
        return RepositoryResource::collection($searchService->search($request->input('filter_by',[]),
            $request->input('sort_by'),$request->input('sort_direction'),
            $request->input('per_page',10)));
    }
}
