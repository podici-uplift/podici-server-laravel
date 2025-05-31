<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;

class RequirementBuilder
{
    public function __construct(
        protected array $fields
    ) {
        //
    }

    /**
     * Generates a required_without validation rule string
     *
     * @param  string  $exception  The field name that is an exception
     * @return string The generated validation rule string
     */
    public function requiredWithout(string $exception): string
    {
        return $this->generateStatement($exception, 'required_without');
    }

    /**
     * Generates a required_without_all validation rule string
     *
     * @param  string  $exception  The field name that is an exception
     * @return string The generated validation rule string
     */
    public function requiredWithoutAll(string $exception): string
    {
        return $this->generateStatement($exception, 'required_without_all');
    }

    /**
     * Generates a validation rule statement excluding a specific field.
     *
     * @param  string  $exception  The field name to exclude from the rule.
     * @param  string  $rule  The validation rule to apply.
     * @return string The generated validation rule statement.
     */
    private function generateStatement(string $exception, string $rule): string
    {
        $statement = implode(',', array_diff($this->fields, [$exception]));

        return "$rule:$statement";
    }
}
