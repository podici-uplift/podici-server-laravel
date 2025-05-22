<?php

namespace App\Http\Requests\Auth;

use App\Rules\Regex\ShopName as ShopNameRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string', new ShopNameRule],
            'is_adult_shop' => ['boolean'],
        ];
    }
}
