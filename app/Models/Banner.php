<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstant;
use App\Manager\ImageUploadManager;
use App\Manager\Utility\Formatter;
use App\Manager\Utility\Utility;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/banner-photos/';
    public const PHOTO_WIDTH       = 600;
    public const PHOTO_HEIGHT      = 600;

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const LOCATION_HOME_TOP = 1;

    public const LOCATION_LIST = [
        self::LOCATION_HOME_TOP => 'Hero banner Top',
    ];

    public const LOCATION_SLUG_LIST = [
        self::LOCATION_HOME_TOP => 'home_top',
    ];

    public const TYPE_VIDEO = 2;
    public const TYPE_IMAGE = 3;

    public const TYPE_LIST = [
        self::TYPE_VIDEO => 'Video',
        self::TYPE_IMAGE => 'Image',
    ];


    public function get_banners(Request $request, array $column = null, bool $all = null): Collection | LengthAwarePaginator
    {
        $query = self::query()->with('photo');

        if ($column) {
            $query->select($column);
        }

        if ($request->input('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->input('status')) {
            $query->where('status', $request->status);
        }

        if ($request->input('location')) {
            $query->where('location', $request->location);
        }

        if ($request->input('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->input('order_by_column')) {
            $direction = $request->input('order_by', 'asc') ?? 'asc';
            $query->orderBy($request->input('order_by_column'), $direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        if ($all) {
            return $query->get();
        }

        return $query->paginate($request->per_page ?? GlobalConstant::DEFAULT_PAGINATION);
    }

    /**
     * @throws Exception
     */
    private function upload_photo(Request $request, Banner|Model $banner): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($banner->title))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($banner->photo && !empty($banner->photo?->photo)) {
            ImageUploadManager::deletePhoto($banner->photo?->photo);
            $banner->photo->delete();
        }
        $banner->photo()->create($media_data);
    }

    public function prepare_data($request, Banner $banner = null): array
    {
        if ($banner) {
            $data['banner'] = [
                'title'         => $request->input('title') ?? $banner->title,
                'description'   => $request->input('description'),
                'link'          => Formatter::url_format($request->input('link')),
                'video_url'     => Formatter::youtube_url_format($request->input('video_url')) ?? null,
                'sort_order'    => $request->input('sort_order'),
                'location'      => $request->input('location') ?? $banner->location,
                'status'        => $request->input('status'),
                'type'          => $request->input('type') ?? $banner->type,
            ];
        } else {
            $data['banner'] = [
                'title'         => $request->input('title'),
                'description'   => $request->input('description'),
                'link'          => Formatter::url_format($request->input('link')),
                'video_url'     => Formatter::youtube_url_format($request->input('video_url')) ?? null,
                'sort_order'    => $request->input('sort_order') ?? 0,
                'location'      => $request->input('location'),
                'status'        => $request->input('status') ?? self::STATUS_INACTIVE,
                'type'          => $request->input('type'),
            ];
        }

        return $data;
    }

    public function store_banner($request): Builder | Model
    {
        $data = $this->prepare_data($request);
        $banner = self::create($data['banner']);

        $this->upload_photo($request, $banner);
        return $banner;
    }

    public function update_banner($request, Banner $banner): Builder | Model
    {
        $data = $this->prepare_data($request, $banner);
        $banner->update($data['banner']);

        $this->upload_photo($request, $banner);
        return $banner;
    }

    public function delete_banner(Banner $banner): bool
    {
        if ($banner->photo?->photo) {
            ImageUploadManager::deletePhoto($banner->photo?->photo);
            $banner->photo?->delete();
        }
        $banner->delete();
        return true;
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

    /**
     * @return Collection
     */
    final public function get_banner_by_location(array $locations)
    {
        $cache_key = 'banner_location_' . implode('_', $locations);
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }

        $banners = self::query()->with('photo')->whereIn('location', $locations)->where('status', self::STATUS_ACTIVE)->orderBy('sort_order', 'asc')->with('photo')->get();

        Cache::put($cache_key, $banners, GlobalConstant::CACHE_EXPIRY);

        return $banners;
    }
}
