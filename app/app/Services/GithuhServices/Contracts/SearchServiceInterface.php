<?php

namespace App\Services\GithuhServices\Contracts;

use Illuminate\Support\Collection;

interface SearchServiceInterface {

    public function search(array $filters = [],string $sortBy = null,
                           string $sortDirection = null, $perPage = 10):Collection;

}
