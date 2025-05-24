<?php

namespace App\Http\Requests\Auth;

use App\Rules\Regex\UsernameRegexRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetupUsernameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->usernameUpdateHasCooledDown();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:32',
                Rule::unique('users', 'username'),
                new UsernameRegexRule,
            ],
        ];
    }

    private function usernameUpdateHasCooledDown()
    {
        $usernameLatestUpdate = $this->user()->getFieldLatestUpdate('username');

        if (! $usernameLatestUpdate) return true;

        return $usernameLatestUpdate->hasCooldown(
            config('settings.user.username_update_cooldown', 0)
        );
    }
}
