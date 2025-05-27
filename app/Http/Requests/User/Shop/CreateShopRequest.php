<?php

namespace App\Http\Requests\User\Shop;

use App\Rules\BlacklistedShopNameRule;
use App\Rules\Regex\ShopNameRegexRule;
use App\Rules\UniqueShopNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CreateShopRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! $this->user()->shop()->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                new ShopNameRegexRule,
                new BlacklistedShopNameRule,
                new UniqueShopNameRule,
            ],
            'is_adult_shop' => ['boolean'],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            fn (Validator $validator) => $this->ensureUserIsOldEnoughToCreateAdultShops($validator),
        ];
    }

    private function ensureUserIsOldEnoughToCreateAdultShops(Validator $validator)
    {
        if ($this->safe()->boolean('is_adult_shop') && ! $this->user()->is_adult) {
            $validator->errors()->add('is_adult_shop', __('validation.user_too_young', [
                'adultAge' => config('settings.adult_age'),
                'action' => 'create adult shops',
            ]));
        }
    }
}
