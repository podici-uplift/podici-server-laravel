<?php

namespace App\Http\Requests\Traits;

use App\Support\RequirementBuilder;

trait HasRequirementBuilder
{
    private RequirementBuilder $requirementBuilder;

    /**
     * Get the fields required for profile update.
     *
     * @return array<string> The list of fields that are required.
     */
    abstract protected function requirementFields(): array;

    /**
     * Generates a required_without validation rule string
     *
     * @param  string  $exception  The field name that is an exception
     * @return string The generated validation rule string
     */
    protected function requiredWithout(string $exception): string
    {
        return $this->requirementBuilder()->requiredWithout($exception);
    }

    /**
     * Generates a required_without_all validation rule string
     *
     * @param  string  $exception  The field name that is an exception
     * @return string The generated validation rule string
     */
    protected function requiredWithoutAll(string $exception): string
    {
        return $this->requirementBuilder()->requiredWithoutAll($exception);
    }

    private function requirementBuilder(): RequirementBuilder
    {
        return $this->requirementBuilder ??= new RequirementBuilder($this->requirementFields());
    }
}
