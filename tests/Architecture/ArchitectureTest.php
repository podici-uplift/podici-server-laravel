<?php

$modelTraits = "App\Models\Traits";

arch()
    ->expect('App')
    // ->toUseStrictTypes()
    ->not->toUse(['die', 'dd', 'dump']);

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
arch()->preset()->laravel();
arch()->preset()->security()->ignoring('md5');
