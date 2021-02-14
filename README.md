

## github Repositories List 

Simple show case for listing public repositories from github api

##Getting Started
Please clone this app with:

git clone https://github.com/AbdallaZaki/our-hotels.git

## Prerequisites

1- Docker 

2- Docker Compose ^3.5

### Installing

1- Run docker-compose up to build and run the services

```
docker-compose up
```

2- install packages using composer

```
docker-compose exec web composer install
```

3- copy .env.example file to .env with this command

```
cp .env.example .env 
```

4- run key generation command to create app secret key

```
docker-compose exec web php artisan key:generate
```
## Running tests

Just run this command in the project root to run tests:

```
docker-compose exec web vendor/bin/phpunit
```
##Testing search api
Just open your browser and enter something like:

```
http://localhost:8080/api/v1/search?filter_by[language]=Javascript&sort_by=forks&sort_direction=desc&per_page=10
```

## App skeleton
1- App/Services contains GithubServices

2- App/Http/Controllers/APi/V1/RepositoriesService contains SearchController

3- App/Providers/DependenciesServiceProvider register github service to service container 

## License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).
