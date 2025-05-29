<?php

namespace App\Http\Controllers\API\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\UploadImageRequest;
use Illuminate\Http\Request;

/**
 * Upload Image Controller
 *
 * @tags Media
 */
class UploadImageController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UploadImageRequest $request)
    {
        //
    }
}
