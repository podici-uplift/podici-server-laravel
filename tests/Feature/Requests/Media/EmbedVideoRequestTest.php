<?php

use App\Http\Requests\Media\EmbedVideoRequest;
use Tests\Datasets\EmbedVideoRequestDatasets;

it('Validates embed video request', function (string $platform, string $url, string $purpose) {
    $request = new EmbedVideoRequest;

    $data = ['platform' => $platform, 'url' => $url, 'purpose' => $purpose];

    $rules = $request->rules();

    $validator = Validator::make($data, $rules);

    expect($validator->fails())->toBeFalse();

    // expect($validator->errors()->has('url'))->toBeTrue();
})->with(EmbedVideoRequestDatasets::validUrls());
