<?php

namespace App\Http\Requests\User;

use App\Enums\Country;
use App\Enums\Gender;
use App\Logics\RequirementBuilder;
use App\Rules\Regex\LegalNameRegexRule;
use App\Rules\Regex\PhoneNumberRegexRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $requirementBuilder = new RequirementBuilder([
            'phone',
            'first_name',
            'last_name',
            'other_names',
            'gender',
            'bio'
        ]);

        return [
            'phone' => [
                'string',
                new PhoneNumberRegexRule(Country::NIGERIA),
                $requirementBuilder->requiredWithoutAll('phone'),
            ],
            'first_name' => [
                'string',
                new LegalNameRegexRule,
                $requirementBuilder->requiredWithoutAll('first_name'),
            ],
            'last_name' => [
                'string',
                new LegalNameRegexRule,
                $requirementBuilder->requiredWithoutAll('last_name'),
            ],
            'other_names' => [
                'string',
                new LegalNameRegexRule(true),
                $requirementBuilder->requiredWithoutAll('other_names'),
            ],
            'gender' => [
                Rule::enum(Gender::class),
                $requirementBuilder->requiredWithoutAll('gender'),
            ],
            'bio' => [
                'string',
                'max:248',
                $requirementBuilder->requiredWithoutAll('bio'),
            ],
        ];
    }
}
