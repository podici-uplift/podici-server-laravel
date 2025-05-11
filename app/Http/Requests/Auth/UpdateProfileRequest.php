<?php

namespace App\Http\Requests\Auth;

use App\Enums\Gender;
use App\Rules\PhoneNumber;
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
                new PhoneNumber,
            ],
            'first_name' => [
                'string',
                'regex:/^[A-Za-z][A-Za-z\'\s-]{1,24}$/',
            ],
            'last_name' => [
                'string',
                'regex:/^[A-Za-z][A-Za-z\'\s-]{1,24}$/',
            ],
            'other_names' => [
                'string',
                'regex:/^[A-Za-z][A-Za-z\'\s-]{0,48}$/',
            ],
            'gender' => [
                Rule::enum(Gender::class),
            ],
            'bio' => [
                'string',
                'max:248',
            ],
        ];
    }
}
