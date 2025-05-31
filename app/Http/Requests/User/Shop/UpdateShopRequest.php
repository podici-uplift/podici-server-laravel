<?php

namespace App\Http\Requests\User\Shop;

use App\Enums\ShopStatus;
use App\Http\Requests\Traits\HasRequirementBuilder;
use App\Rules\BlacklistedShopNameRule;
use App\Rules\Regex\ShopNameRegexRule;
use App\Rules\UniqueShopNameRule;
use App\Validation\User\Shop\ValidateShopUpdate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateShopRequest extends FormRequest
{
    use HasRequirementBuilder;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->shop()->exists();
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
                $this->requiredWithoutAll('name'),
                'string',
                new ShopNameRegexRule,
                new BlacklistedShopNameRule,
                new UniqueShopNameRule,
            ],
            'description' => [
                $this->requiredWithoutAll('description'),
                'nullable',
                'string',
                'min:1',
                'max:255',
            ],
            'is_adult_shop' => [
                $this->requiredWithoutAll('is_adult_shop'),
                'boolean',
            ],
            'status' => [
                $this->requiredWithoutAll('status'),
                Rule::enum(ShopStatus::class),
            ],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     */
    public function after(): array
    {
        return [
            new ValidateShopUpdate,
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function requirementFields(): array
    {
        return ['name', 'description', 'tags', 'is_adult_shop', 'status'];
    }
}
