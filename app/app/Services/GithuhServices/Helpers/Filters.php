<?php

namespace App\Services\GithuhServices\Helpers;

class Filters
{
    private string $filters = "";

    private array $defaultFilters = [
        'created' => 'date',
        'language' => 'string'
    ];

    public array $allowedLanguages = [
        'PHP', 'Ruby', 'Java', 'C', 'C++','C#','Javascript','Shell','Rust' // for example
    ];

    /**
     * @param array $filters
     * @return string
     */
    public function filterBy(array $filters):string
    {
        $validFilters = array_intersect_key($this->defaultFilters,$filters);

        foreach ($validFilters as $key => $filter){
            $this->addFilter($key,$filters[$key],$filter);
        }

        if(!count($validFilters))
            $this->addFilter('language',$this->allowedLanguages[0],'string');

        return trim($this->filters);
    }

    /**
     * @param string $filterKey
     * @param string $filterValue
     * @param string $filterType
     */
    private function addFilter(string $filterKey , string $filterValue ,string $filterType){
         $filter = "{$filterKey}:";
         if($filterType == 'date')
             $filter .= '>=';
         $this->filters .= "{$filter}{$filterValue} ";
    }
}
