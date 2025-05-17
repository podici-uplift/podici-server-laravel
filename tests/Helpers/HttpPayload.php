<?php

namespace Tests\Helpers;

use App\Enums\Country;
use App\Enums\Gender;
use App\Models\User;
use Exception;

class HttpPayload
{
    protected array $payload = [];

    public function __construct()
    {
    }

    protected function payload(callable $generator): self
    {
        $this->payload = $generator();

        return $this;
    }

    public function mod(string $field, string $value): self
    {
        $this->payload[$field] = $value;

        return $this;
    }

    public function modViaArray(array $payload): self
    {
        $this->payload = array_merge($this->payload, $payload);

        return $this;
    }

    public function value(string $key): mixed
    {
        return data_get($this->payload, $key);
    }

    public function data(): array // @todo: Change to data
    {
        return $this->payload;
    }

    public function login(): self
    {
        return $this->payload(fn () => [
            'email' => fake()->email(),
            'password' => fake()->password(12),
        ]);
    }

    public function register(): self
    {
        $password = fake()->password(12);

        return $this->payload(fn () => [
            'email' => fake()->email(),
            'name' => fake()->userName(),
            'password' => $password,
            'password_confirmation' => $password,
        ]);
    }

    public function profileUpdate(): self
    {
        return $this->payload(fn () => [
            'phone' => fake()->numerify("23480########"),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'other_names' => fake()->lastName(),
            'gender' => fake()->randomElement(Gender::cases()),
            'bio' => fake()->realText(),
        ]);
    }
}
