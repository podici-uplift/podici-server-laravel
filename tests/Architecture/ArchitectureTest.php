<?php

$modelTraits = "App\Models\Traits";

arch()
    ->expect('App')
    ->not->toUse(['die', 'dd', 'dump', 'echo', 'print', 'print_r']);

arch()
    ->expect('App\Models')
    ->toBeClasses()->ignoring($modelTraits)
    ->toExtend('Illuminate\Database\Eloquent\Model')->ignoring($modelTraits);

arch()
    ->expect('App\Http')
    ->toOnlyBeUsedIn('App\Http');

arch()
    ->expect('App\*\Traits')
    ->toBeTraits();

arch()->preset()->php();

arch()->preset()->laravel()
    ->ignoring("App\Http\Controllers\API\Local")
    ->ignoring("App\Http\Controllers\API\Auth\SocialiteController")
    ->ignoring("App\Providers\AppServiceProvider");

arch()->preset()->security();
