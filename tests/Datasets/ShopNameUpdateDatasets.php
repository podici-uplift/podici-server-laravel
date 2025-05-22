<?php

namespace Tests\Datasets;

use App\Logics\BlacklistedNames;

class ShopNameUpdateDatasets
{
    public static function blacklistedShopnames()
    {
        return BlacklistedNames::shopnames();
    }
}
