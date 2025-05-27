<?php

namespace App\Logics;

class RequirementBuilder
{
    public function __construct(
        protected array $fields
    ) {
        //
    }

    public function requiredWithout(string $exception): string
    {
        return $this->generateStatement($exception, 'required_without');
    }

    public function requiredWithoutAll(string $exception): string
    {
        return $this->generateStatement($exception, 'required_without_all');
    }

    private function generateStatement(string $exception, string $rule): string
    {
        $statement = implode(',', array_diff($this->fields, [$exception]));

        return "$rule:$statement";
    }
}
