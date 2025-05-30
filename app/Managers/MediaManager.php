<?php

namespace App\Managers;

use App\Data\EmbedUrlData;
use App\Enums\Media\MediaPurpose;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class MediaManager
{
    public const EMBED_DISK = 'embed';

    public const RAW_DISK = 'raw';

    public const LOCAL_DISK = 'local';

    /**
     * Uploads a media file to the specified disk and purpose.
     *
     * @param  User  $user  The user that is uploading the media file.
     * @param  UploadedFile  $file  The uploaded file to be saved.
     * @param  MediaPurpose  $purpose  The purpose of the uploaded file.
     * @param  mixed  $meta  Optional meta data to be stored with the media file.
     * @param  string|null  $disk  The disk to store the media file on. If not specified, will use the default disk.
     * @return Media The created media instance.
     */
    public static function upload(
        User $user,
        UploadedFile $file,
        MediaPurpose $purpose,
        mixed $meta = null,
        ?string $disk = null
    ): Media {
        $disk = $disk ?? config('filesystems.default');

        $path = $file->store($purpose->storageDirectory(), $disk);

        return Media::create([
            'user_id' => $user->getKey(),
            'disk' => $disk,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'purpose' => $purpose->value,
            'meta' => $meta,
        ]);
    }

    public static function storeRaw(
        User $user,
        MediaPurpose $purpose,
        string $url,
        mixed $meta = null,
    ): Media {
        return Media::create([
            'user_id' => $user->getKey(),
            'disk' => self::RAW_DISK,
            'path' => $url,
            'purpose' => $purpose->value,
            'meta' => $meta,
        ]);
    }

    public static function storeEmbed(
        User $user,
        MediaPurpose $purpose,
        EmbedUrlData $data,
        mixed $meta = null,
    ): Media {
        return Media::create([
            'user_id' => $user->getKey(),
            'disk' => self::EMBED_DISK,
            'path' => $data->url,
            'embed_platform' => $data->platform,
            'embed_thumbnail' => $data->thumbnail,
            'embed_code' => $data->code,
            'purpose' => $purpose->value,
            'meta' => [
                'title' => $data->title,
                'author_name' => $data->authorName,
            ],
        ]);
    }

    /**
     * Retrieves the URL for a given media file.
     *
     * If the media file is stored on the 'raw' disk, it returns the direct path.
     * Otherwise, it generates a URL using the specified storage disk.
     *
     * @param  Media  $media  The media instance for which to get the URL.
     * @return string The URL or path to the media file.
     */
    public static function getUrl(Media $media): string
    {
        return match ($media->disk) {
            self::RAW_DISK, self::EMBED_DISK => $media->path,

            self::LOCAL_DISK => Storage::disk($media->disk)->temporaryUrl(
                $media->path,
                now()->addMinutes(config('settings.media.temporary_local_url_lifetime')),
            ),

            default => Storage::disk($media->disk)
                ->url($media->path),
        };
    }

    /**
     * Deletes a media file from the storage.
     */
    public static function delete(Media $media): bool
    {
        if (! $media->disk == 'raw') {
            Storage::disk($media->disk)->delete($media->path);
        }

        return $media->delete();
    }

    /**
     * Deletes multiple media files from the storage.
     *
     * @param  \Illuminate\Support\Collection<Media>|array<Media>  $files
     */
    public static function deleteMany(Collection|array $files): void
    {
        collect($files)->each(fn ($media) => self::delete($media));
    }
}
