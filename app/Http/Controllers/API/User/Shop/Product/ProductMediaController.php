<?php

namespace App\Http\Controllers\API\User\Shop\Product;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\Product;
use App\Support\AppResponse;
use Illuminate\Http\Request;

/**
 * ProductMediaController
 *
 * @tags My Shop
 */
class ProductMediaController extends Controller
{
    /**
     * Get Product Medias
     */
    public function index(Request $request, Product $product)
    {
        //
    }

    /**
     * Add Product media
     */
    public function store(Request $request, Product $product)
    {
        //
    }

    /**
     * Update Product Media
     */
    public function update(Request $request, Product $product, Media $media)
    {
        //
    }

    /**
     * Remove Product Media
     */
    public function destroy(Product $product, Media $media)
    {
        //
    }
}
