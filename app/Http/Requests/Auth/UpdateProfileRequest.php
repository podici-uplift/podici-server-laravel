<?php

namespace App\Http\Requests\Auth;

use App\Enums\Country;
use App\Enums\Gender;
use App\Rules\Regex\LegalName;
use App\Rules\Regex\PhoneNumber;
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
        return [
            'phone' => [
                'string',
                new PhoneNumber(Country::NIGERIA),
                'required_without_all:phone,first_name,last_name,other_names,gender,bio',
            ],
            'first_name' => [
                'string',
                new LegalName,
                'required_without_all:phone,last_name,other_names,gender,bio',
            ],
            'last_name' => [
                'string',
                new LegalName,
                'required_without_all:phone,first_name,other_names,gender,bio',
            ],
            'other_names' => [
                'string',
                new LegalName(true),
                'required_without_all:phone,first_name,last_name,gender,bio',
            ],
            'gender' => [
                Rule::enum(Gender::class),
                'required_without_all:phone,first_name,last_name,other_names,bio',
            ],
            'bio' => [
                'string',
                'max:248',
                'required_without_all:phone,first_name,last_name,other_names,gender',
            ],
        ];
    }
}
