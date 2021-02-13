<?php


namespace App\Services\GithuhServices\Concretes;

use App\Services\GithuhServices\Contracts\SearchServiceInterface;
use App\Services\GithuhServices\Helpers\Filters;
use App\Services\GithuhServices\Helpers\Sorter;
use App\Services\GithuhServices\ViewModels\Repository;
use Github\Client;
use Github\ResultPager;
use GrahamCampbell\GitHub\GitHubManager;
use Illuminate\Support\Collection;

class SearchService implements SearchServiceInterface {

    protected Client $github;

    public function __construct(GitHubManager $github)
    {
        $this->github = $github->connection();
    }

    /**
     * @param array $filters
     * @param string|null $sortBy
     * @param string|null $sortDirection
     * @param int $perPage
     * @return Collection
     */
    public function search(array $filters = [],string $sortBy = null, string $sortDirection = null, $perPage = 10):Collection
    {
        $filters = (new Filters())->filterBy($filters);

        list($sortBy,$direction) = ($sortBy&&$sortDirection)?
            (new Sorter())->sortBy($sortBy,$sortDirection):(new Sorter())->sortBy();

        $paginator = new ResultPager($this->github,$perPage);

        $results = $paginator->fetch(
            $this->github->api('search'),'repositories', [$filters, $sortBy , $direction]);

        return (!empty($results['items']))?
            collect($results['items'])->map( fn ($result) => new Repository($result)):new Collection();

    }
}
