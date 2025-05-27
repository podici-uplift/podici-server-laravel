<?php

namespace App\Validation\User\Shop;

use App\Models\Shop;
use Illuminate\Validation\Validator;

class ValidateShopUpdate
{
    protected Shop $shop;

    public function __invoke(Validator $validator)
    {
        $this->shop = request()->user()->shop;

        if ($validator->safe()->filled('name')) {
            $this->checkCanUpdateName($validator);
        }

        if ($validator->safe()->filled('is_adult_shop')) {
            $this->checkCanChangeAdultStatus($validator);
        }
    }

    private function checkCanUpdateName(Validator $validator): void
    {
        $lastNameUpdate = $this->shop->getFieldLatestUpdate('name');

        if (! $lastNameUpdate) {
            return;
        }

        $cooldownDuration = config('settings.shop.name_update_cooldown');

        if (! $lastNameUpdate->hasCooldown($cooldownDuration)) {
            $validator->errors()->add('name', __('validation.shop_name_update_hot', [
                'nextUpdateDateTime' => $lastNameUpdate->created_at->addDays($cooldownDuration)->toString(),
            ]));
        }
    }

    private function checkCanChangeAdultStatus(Validator $validator)
    {
        $updateToAdultShop = $validator->safe()->boolean('is_adult_shop');

        if (! $updateToAdultShop) {
            return;
        }

        if (request()->user()->is_adult) {
            return;
        }

        $validator->errors()->add('is_adult_shop', __('validation.user_too_young', [
            'adultAge' => config('settings.adult_age'),
            'action' => 'set your shop as an adult shop',
        ]));
    }
}
