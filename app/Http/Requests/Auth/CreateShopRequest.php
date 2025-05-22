<?php

namespace App\Http\Requests\Auth;

use App\Logics\ShopName;
use App\Rules\BlacklistedShopNameRule;
use App\Rules\Regex\ShopNameRegexRule;
use App\Rules\UniqueShopNameRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
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
            //
        ];
    }
}
