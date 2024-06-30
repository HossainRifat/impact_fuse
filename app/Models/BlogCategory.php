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
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class BlogCategory extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/blog-category/';
    public const PHOTO_WIDTH = 600;
    public const PHOTO_HEIGHT = 600;

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    final public function get_categories(Request $request, bool $all = false): Collection|LengthAwarePaginator
    {
        $query = self::query()->with(['photo', 'parent']);

        if ($request->input('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
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
        return $query->paginate($request->input('per_page', GlobalConstant::DEFAULT_PAGINATION));
    }

    /**
     * @throws Exception
     */
    private function upload_photo(Request $request, BlogCategory|Model $blog_cat): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($blog_cat->name))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($blog_cat->photo && !empty($blog_cat->photo?->photo)) {
            ImageUploadManager::deletePhoto($blog_cat->photo?->photo);
            $blog_cat->photo->delete();
        }
        $blog_cat->photo()->create($media_data);
    }

    public function prepare_data($request, BlogCategory $category = null): array
    {
        if ($category) {
            $data['category'] = [
                'name'            => $request->input('name') ?? $category->name,
                'slug'            => $request->input('slug') ?? $category->slug,
                'description'     => $request->input('description'),
                'parent_id'       => $request->input('parent_id'),
                'status'          => $request->input('status') ?? self::STATUS_INACTIVE,
                'display_order'   => $request->input('display_order') ?? 0,
            ];
        } else {
            $data['category'] = [
                'name'            => $request->input('name'),
                'slug'            => $request->input('slug'),
                'description'     => $request->input('description'),
                'parent_id'       => $request->input('parent_id'),
                'status'          => $request->input('status') ?? self::STATUS_INACTIVE,
                'display_order'   => $request->input('display_order') ?? 0,
            ];
        }

        $data['seo'] = (new Seo())->prepare_data($request);

        return $data;
    }

    public function create_category($request): Builder | Model
    {
        $data     = $this->prepare_data($request);
        $category = self::query()->create($data['category']);
        $seo      = $category->seo()->create($data['seo']);

        $this->upload_photo($request, $category);
        $seo->upload_photo($request, $seo);

        return $category;
    }

    public function update_category($request, BlogCategory $category): bool
    {
        $data = $this->prepare_data($request, $category);
        $category->update($data['category']);
        $seo = $category->seo;
        $seo->update($data['seo']);

        $this->upload_photo($request, $category);
        $seo->upload_photo($request, $seo, self::PHOTO_UPLOAD_PATH);

        return true;
    }

    public function delete_category(BlogCategory $category): bool
    {
        if ($category->photo) {
            ImageUploadManager::deletePhoto($category->photo->photo);
            $category->photo?->delete();
        }
        if ($category->seo?->photo) {
            ImageUploadManager::deletePhoto($category->seo?->photo?->photo);
            $category->seo?->delete();
        }
        return $category->delete();
    }

    public function get_categories_assoc(): Collection
    {
        return self::query()->where('status', self::STATUS_ACTIVE)->orderBy('display_order')->pluck('name', 'id');
    }
    /**
     * @return BelongsTo
     */
    final public function parent(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
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
     * @return MorphOne
     */
    final public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
