<?php

namespace App\Http\Requests\Auth;

use App\Rules\Regex\Username;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SetupUsernameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $lastUpdatedAt = $this->user()->username_last_updated_at;

        if (is_null($lastUpdatedAt)) {
            return true;
        }

        $cooldownDuration = (int) config('settings.user.username_update_cooldown', 0);

        if ($cooldownDuration <= 0) {
            return true;
        }

        return $lastUpdatedAt->lt(now()->subDays($cooldownDuration));
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
                new Username,
            ],
        ];
    }
}
