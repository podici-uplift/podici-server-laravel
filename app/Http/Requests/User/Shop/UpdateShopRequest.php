<?php

namespace App\Http\Requests\User\Shop;

use App\Enums\ShopStatus;
use App\Logics\RequirementBuilder;
use App\Rules\BlacklistedShopNameRule;
use App\Rules\Regex\ShopNameRegexRule;
use App\Rules\UniqueShopNameRule;
use App\Validation\User\Shop\ValidateShopUpdate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Concerns\InteractsWithInput;
use Illuminate\Validation\Rule;

class UpdateShopRequest extends FormRequest
{
    // use InteractsWithInput;

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
        $requirementBuilder = new RequirementBuilder([
            'name',
            'description',
            'tags',
            'is_adult_shop',
            'status',
        ]);

        return [
            'name' => [
                $requirementBuilder->requiredWithoutAll('name'),
                'string',
                new ShopNameRegexRule,
                new BlacklistedShopNameRule,
                new UniqueShopNameRule,
            ],
            'description' => [
                $requirementBuilder->requiredWithoutAll('description'),
                'nullable',
                'string',
                'min:1',
                'max:255',
            ],
            'is_adult_shop' => [
                $requirementBuilder->requiredWithoutAll('is_adult_shop'),
                'boolean',
            ],
            'status' => [
                $requirementBuilder->requiredWithoutAll('status'),
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
}
