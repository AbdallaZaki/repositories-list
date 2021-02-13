<?php

namespace App\Services\GithuhServices\Helpers;

class Sorter {

    public array $defaultSorters = [
        'stars' => 'desc',
        'forks' => 'desc'
    ];

    public array $allowedDirections = [
       'desc', 'asc'
    ];

    /**
     * @param string $sorter
     * @param string $direction
     * @return string[]
     */
    public function sortBy(string $sorter = 'stars', string $direction = 'desc'):array
    {
        return (!empty($this->defaultSorters[$sorter]) && in_array($direction,$this->allowedDirections))?
            [$sorter,$direction]:['stars','desc'];

    }

}
