<?php

namespace Tests\Helpers;

use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Testing\TestResponse;

class HttpTester
{
    protected ?TestResponse $response = null;

    public function __construct(
        protected string $method,
        protected string $uri,
    ) {
        //
    }

    public function send(array $payload = [], array $headers = []): self
    {
        /** @var TestCase $testCase */
        $testCase = test();

        $this->response = $testCase->json($this->method, $this->uri, $payload, $headers);

        return $this;
    }

    public function sendAs(AuthUser $as, array $payload = [], array $headers = []): self
    {
        /** @var TestCase $testCase */
        $testCase = test();

        $this->response = $testCase->actingAs($as, 'sanctum')
            ->json($this->method, $this->uri, $payload, $headers);

        return $this;
    }

    public function handleResponse(callable $callback): self
    {
        if (! $this->response) {
            throw new Exception('Test Error: Request not sent yet.');
        }

        $callback($this->response);

        return $this;
    }

    public function dump(): self
    {
        return $this->handleResponse(
            fn(TestResponse $response) => $response->dump()
        );
    }

    public function responseValue(string $key, mixed $default = null): mixed
    {
        return $this->response->json($key) ?? $default;
    }

    /*
    | |--------------------------------------------------------------------------
    | Expectations
    | |--------------------------------------------------------------------------
    */

    public function expect(string $key, mixed $value): self
    {
        return $this->handleResponse(
            fn(TestResponse $response) => $response->assertJson(
                fn(AssertableJson $json) => $json->where($key, $value)->etc()
            )
        );
    }

    public function expectAll(array $bindings): self
    {
        return $this->handleResponse(
            fn(TestResponse $response) => $response->assertJson(
                fn(AssertableJson $json) => $json->whereAll($bindings)->etc()
            )
        );
    }

    public function expectMessage(string $messageKey, array $messageReplace = []): self
    {
        return $this->expect('message', __($messageKey, $messageReplace));
    }

    public function expectStatus(int $status): self
    {
        return $this->handleResponse(
            fn(TestResponse $response) => $response->assertStatus($status)
        );
    }

    public function expectStatusAndMessage(int $status, string $messageKey, array $messageReplace = []): self
    {
        return $this->expectStatus($status)->expectMessage($messageKey, $messageReplace);
    }

    public function expectAllType(array $bindings): self
    {
        return $this->handleResponse(
            fn(TestResponse $response) => $response->assertJson(
                fn(AssertableJson $json) => $json->whereAllType($bindings)
            )
        );
    }

    public function expectResource(): self
    {
        return $this->expectAllType([
            'status' => 'string',
            'statusCode' => 'integer',
            'message' => 'string',
            'resource' => 'array'
        ]);
    }

    public function expectPaginated(): self
    {
        return $this->expectAllType([
            'message' => 'string',
            'data' => 'array',

            'links' => 'array',
            'links.first' => 'string|null',
            'links.last' => 'string|null',
            'links.prev' => 'string|null',
            'links.next' => 'string|null',

            'meta' => 'array',
            'meta.current_page' => 'integer',
            'meta.from' => 'integer|null',
            'meta.last_page' => 'integer',
            'meta.links' => 'array',
            'meta.path' => 'string',
            'meta.per_page' => 'integer',
            'meta.to' => 'integer|null',
            'meta.total' => 'integer',
        ]);
    }

    /*
    | |--------------------------------------------------------------------------
    | Status Expectations
    | |--------------------------------------------------------------------------
    */

    public function expectOk(string $messageKey, array $messageReplace = []): self
    {
        return $this->expectStatusAndMessage(200, $messageKey, $messageReplace);
    }

    public function expectCreated(string $messageKey, array $messageReplace = []): self
    {
        return $this->expectStatusAndMessage(201, $messageKey, $messageReplace);
    }

    public function expectBadRequest(?string $messageKey = null, array $messageReplace = []): self
    {
        return $this->expectStatusAndMessage(400, $messageKey, $messageReplace);
    }

    public function expectAuthenticationError(?string $messageKey = null, array $messageReplace = []): self
    {
        return $this->expectStatusAndMessage(401, $messageKey ?? 'Unauthenticated.', $messageReplace);
    }

    public function expectUnauthorized(?string $messageKey = null, array $messageReplace = []): self
    {
        return $this->expectStatusAndMessage(403, $messageKey ?? 'This action is unauthorized.', $messageReplace);
    }

    public function expectNotFound(?string $messageKey = null, array $messageReplace = []): self
    {
        return $this->expectStatus(404);
    }

    public function expectValidationError(array $fields = []): self
    {
        return $this->expectStatus(422)->expectAllType([
            'message' => 'string',
            'errors' => 'array',
        ])->handleResponse(function (TestResponse $response) use ($fields) {
            if (count($fields)) {
                $response->assertInvalid($fields);
            }
        });
    }

    public function expectTooManyRequests(?string $messageKey = null, array $messageReplace = []): self
    {
        return $this->expectStatusAndMessage(429, $messageKey ?? 'Too Many Attempts.', $messageReplace);
    }
}
