<?php

namespace App\Http\Requests\User;

use App\Enums\Country;
use App\Enums\Gender;
use App\Http\Requests\Traits\HasRequirementBuilder;
use App\Rules\Regex\LegalNameRegexRule;
use App\Rules\Regex\PhoneNumberRegexRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    use HasRequirementBuilder;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    protected function requirementFields(): array
    {
        return ['phone', 'first_name', 'last_name', 'other_names', 'gender', 'bio'];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => [
                'string',
                new PhoneNumberRegexRule(Country::NIGERIA),
                $this->requiredWithoutAll('phone'),
            ],
            'first_name' => [
                'string',
                new LegalNameRegexRule,
                $this->requiredWithoutAll('first_name'),
            ],
            'last_name' => [
                'string',
                new LegalNameRegexRule,
                $this->requiredWithoutAll('last_name'),
            ],
            'other_names' => [
                'string',
                new LegalNameRegexRule(true),
                $this->requiredWithoutAll('other_names'),
            ],
            'gender' => [
                Rule::enum(Gender::class),
                $this->requiredWithoutAll('gender'),
            ],
            'bio' => [
                'string',
                'max:248',
                $this->requiredWithoutAll('bio'),
            ],
        ];
    }
}
