<?php

use App\Infrastructure\Laravel\Providers\AppServiceProvider;

return [
    AppServiceProvider::class,
    App\Infrastructure\Laravel\Providers\RepositoryServiceProvider::class,
];
