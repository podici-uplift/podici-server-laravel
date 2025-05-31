<?php

use App\Models\User;
use Database\Factories\UserFactory;
use Tests\Helpers\HttpPayload;
use Tests\Helpers\HttpTester;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "pest()" function to bind a different classes or traits.
|
*/

pest()->extend(TestCase::class)
    ->use(Illuminate\Foundation\Testing\RefreshDatabase::class)
    ->in('Feature');

pest()->beforeEach(function () {
    Event::fake();
})->in('Feature/Controllers');

pest()->beforeEach(function () {
    $this->startMemory = memory_get_usage(true);
})->afterEach(function () {
    $endMemory = memory_get_peak_usage(true);
    $usedMemory = ($endMemory - $this->startMemory) / 1024 / 1024;

    fwrite(STDOUT, sprintf(
        "\nMemory used: %.2f MB - Peak Memory: %.2f MB\n",
        $usedMemory,
        memory_get_peak_usage(true) / 1024 / 1024
    ));
});

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function something()
{
    // ..
}

function testCase($testCase): TestCase
{
    return $testCase;
}

function httpTester(
    string $method,
    string $route,
    bool $routeIsName = true,
    array $routeParams = []
) {
    $uri = $routeIsName ? route($route, $routeParams) : $route;

    return new HttpTester($method, $uri);
}

function httpPayload()
{
    return new HttpPayload;
}

function userFactory(): UserFactory
{
    return User::factory();
}

function createUser(array $payload = []): User
{
    return userFactory()->create($payload);
}
