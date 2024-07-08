<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstant;
use App\Manager\ImageUploadManager;
use App\Manager\Utility\Utility;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/service-photos/';
    public const IS_SHOW_ON_MENU   = 1;
    public const IS_SHOW_ON_HOME   = 1;
    public const IS_FEATURED       = 1;

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    final public function get_service(Request $request, bool $only_active = false): LengthAwarePaginator
    {
        $query = self::query()->with(['photo', 'parent']);
        if ($only_active) {
            $query->where('status', self::STATUS_ACTIVE);
        }
        if ($request->has('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('summary', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('tool_used', 'like', '%' . $request->input('search') . '%');
            });
        }
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('sort_order')) {
            $order_direction = $request->input('order_by') ?? 'desc';
            $query->orderBy($request->input('sort_order', 'id'), $order_direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query->orderBy('id', 'desc')->paginate($request->input('per_page') ?? GlobalConstant::DEFAULT_PAGINATION)->withQueryString();
    }

    final public function get_active_service(bool $is_show_on_home = false, bool $is_featured = false): Collection
    {
        $query = self::query()->with(['photo:id,imageable_type,imageable_id,photo'])->where('status', self::STATUS_ACTIVE)
            ->select('id', 'name', 'slug', 'summary', 'parent_id', 'status', 'sort_order', 'is_featured', 'is_show_on_home', 'is_show_on_menu');
        if ($is_show_on_home) {
            $query->where('is_show_on_home', self::IS_SHOW_ON_HOME);
        }
        if ($is_featured) {
            $query->where('is_featured', self::IS_FEATURED);
        }
        return $query->orderBy('sort_order', 'desc')->get();
    }

    private function upload_photo(Request $request, Service|Model $service): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($service->name))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($service->photo && !empty($service->photo?->photo)) {
            ImageUploadManager::deletePhoto($service->photo?->photo);
            $service->photo->delete();
        }
        $service->photo()->create($media_data);
    }

    private function prepare_data($request, Service $service = null): array
    {
        if ($service) {
            $data['service'] = [
                'name'            => $request->input('name') ?? $service->name,
                'slug'            => $request->input('slug') ?? $service->slug,
                'summary'         => $request->input('summary') ?? $service->summary,
                'tool_used'       => $request->input('tool_used') ?? $service->tool_used,
                'description'     => $request->input('description'),
                'parent_id'       => $request->input('parent_id'),
                'status'          => $request->input('status') ?? self::STATUS_ACTIVE,
                'sort_order'      => $request->input('sort_order') ?? null,
                'is_featured'     => $request->input('is_featured') ?? 0,
                'is_show_on_home' => $request->input('is_show_on_home') ?? 0,
                'is_show_on_menu' => $request->input('is_show_on_menu') ?? 0,
            ];
        } else {
            $data['service'] = [
                'name'            => $request->input('name'),
                'slug'            => $request->input('slug'),
                'summary'         => $request->input('summary'),
                'tool_used'       => $request->input('tool_used'),
                'description'     => $request->input('description'),
                'parent_id'       => $request->input('parent_id'),
                'status'          => $request->input('status') ?? self::STATUS_ACTIVE,
                'sort_order'      => $request->input('sort_order') ?? null,
                'is_featured'     => $request->input('is_featured') ?? 0,
                'is_show_on_home' => $request->input('is_show_on_home') ?? 0,
                'is_show_on_menu' => $request->input('is_show_on_menu') ?? 0,
            ];
        }

        $data['seo'] = (new Seo())->prepare_data($request);

        return $data;
    }

    final public function store_service(Request $request): Builder | Model
    {
        $data    = $this->prepare_data($request);
        $service = self::create($data['service']);
        $seo     = $service->seo()->create($data['seo']);

        $this->upload_photo($request, $service);
        $seo->upload_photo($request, $seo);
        return $service;
    }

    final public function update_service(Request $request, Service $service): Builder | Model
    {
        $data = $this->prepare_data($request, $service);
        $service->update($data['service']);
        $service->seo->update($data['seo']);

        $this->upload_photo($request, $service);
        $service->seo->upload_photo($request, $service->seo);
        return $service;
    }

    final public function delete_service(Service $service): bool
    {
        if ($service->photo && !empty($service->photo->photo)) {
            ImageUploadManager::deletePhoto($service->photo->photo);
            $service->photo->delete();
        }
        if ($service->seo && !empty($service->seo?->photo?->photo)) {
            ImageUploadManager::deletePhoto($service->seo->photo->photo);
            $service->seo->photo->delete();
        }
        $service->seo->delete();
        return $service->delete();
    }

    final public function get_assoc(): Collection
    {
        return self::query()->where('status', self::STATUS_ACTIVE)->orderBy('id', 'desc')->pluck('name', 'id');
    }

    /**
     * @return MorphOne
     */
    final public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
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

    final public function parent(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'parent_id', 'id');
    }

    final public function children(): HasMany
    {
        return $this->hasMany(Service::class, 'parent_id', 'id');
    }
}
