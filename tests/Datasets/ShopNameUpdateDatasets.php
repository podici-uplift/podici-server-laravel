<?php

namespace Tests\Datasets;

use App\Logics\BlacklistedNames\BlacklistedShopNames;

class ShopNameUpdateDatasets
{
    public static function blacklistedShopnames()
    {
        return BlacklistedShopNames::blacklist();
    }
}
