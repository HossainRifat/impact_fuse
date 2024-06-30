<?php

namespace App\Models;

use App\Manager\ImageUploadManager;
use App\Manager\Utility\Utility;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Seo extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const TITLE_LENGTH = 70;
    public const DESCRIPTION_LENGTH = 160;

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/og-photos/';
    public const PHOTO_WIDTH = 1200;
    public const PHOTO_HEIGHT = 630;

    /**
     * @param Request $request
     * @return array
     */
    final public function prepare_data(Request $request): array
    {
        return [
            'title'       => $request->input('meta_title'),
            'keywords'    => $request->input('meta_keywords'),
            'description' => Str::limit($request->input('meta_description'), self::DESCRIPTION_LENGTH)
        ];
    }

    /**
     * @param Request $request
     * @return void
     */
    final public function upload_photo(Request $request, Seo|Model $seo): void
    {
        $file = $request->file('og_image');
        if (is_string($request->input('og_image'))) {
            $file = Storage::get($request->input('og_image'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($seo->title ?? 'seo'))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
        ];
        if ($seo->photo && !empty($seo->photo->photo)) {
            ImageUploadManager::deletePhoto($seo->photo->photo);
            $seo->photo->delete();
        }
        $seo->photo()->create($media_data);
    }

    /**
     * @return BelongsTo
     */
    final public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    final public function updated_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by_id', 'id');
    }

    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable')->orderByDesc('id');
    }

    /**
     * @return MorphOne
     */
    final public function photo(): MorphOne
    {
        return $this->morphOne(MediaGallery::class, 'imageable');
    }

    /**
     * @return MorphMany
     */
    final public function photos(): MorphMany
    {
        return $this->morphMany(MediaGallery::class, 'imageable');
    }
}
