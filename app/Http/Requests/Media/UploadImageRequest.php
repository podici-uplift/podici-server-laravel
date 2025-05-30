<?php

namespace App\Http\Requests\Media;

use App\Enums\Media\MediaPurpose;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'image',
                File::image()
                    ->min(config('settings.media.upload.min_size'))
                    ->max(config('settings.media.upload.max_size')),
            ],
            'purpose' => [
                'required',
                'string',
                Rule::in(MediaPurpose::cases()),
            ],
        ];
    }
}
