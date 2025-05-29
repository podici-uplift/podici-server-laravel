<?php

namespace App\Http\Requests\Media;

use App\Enums\Media\MediaPurpose;
use App\Enums\Media\VideoEmbedPlatforms;
use App\Rules\EmbedVideoUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmbedVideoRequest extends FormRequest
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
            'platform' => ['required', Rule::in(VideoEmbedPlatforms::cases()),],
            'url' => ['required', 'url', new EmbedVideoUrl],
            'purpose' => ['required', 'string', Rule::in(MediaPurpose::cases()),],
        ];
    }
}
