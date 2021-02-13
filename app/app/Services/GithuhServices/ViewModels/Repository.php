<?php

namespace App\Services\GithuhServices\ViewModels;

class Repository {

    public int $id;
    public int $stars;
    public string $url;
    public string $ownerUrl;
    public ?string $description;
    public string $language;
    public int $forks;


    public function __construct(array $params){

        $this->id = $params['id'];
        $this->stars = $params['watchers'];
        $this->url = $params['html_url'];
        $this->ownerUrl = $params['owner']['html_url'];
        $this->description = $params['description'];
        $this->language = $params['language'];
        $this->forks = $params['forks'];
    }
}
