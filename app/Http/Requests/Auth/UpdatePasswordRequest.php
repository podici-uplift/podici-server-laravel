<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UpdatePasswordRequest extends FormRequest
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
            'old_password' => [
                Rule::requiredIf($this->oldPasswordIsRequired()),
                'string',
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
            'invalidate_logins' => ['boolean']
        ];
    }

    private function oldPasswordIsRequired(): bool
    {
        return config('settings.password_update_requires_old_password')
            && $this->user()->password != null;
    }
}
