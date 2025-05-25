<?php

namespace App\Enums;

enum ProductStatus: string
{
    /**
     * User is yet to publish product
     * `published_at == null`
     */
    case DRAFT = 'draft';

    /**
     * Would be published in the future
     * `published_at > now()`
     */
    case COMING_SOON = 'coming_soon';

    /**
     * Product is active
     * `published_at != null
     *  && published_at < now()
     *  && quantity > 0 || quantity == null
     *  && flag is null`
     */
    case ACTIVE = 'active';

    /**
     * Product is on sale
     *
     * Product is active and sale price is not null
     */
    case ON_SALE = 'on_sale';

    /**
     * Product is currently unlisted by user
     */
    case UNLISTED = 'unlisted';

    /**
     * Product has quantity == 0
     * `published_at < now() && quantity == 0`
     */
    case OUT_OF_STOCK = 'out_of_stock';

    /**
     * Product is currently flagged by the system
     */
    case FLAGGED = 'flagged';

    case DELETED = 'deleted';
}
