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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Blog extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/blog-photos/';
    public const PHOTO_WIDTH       = 600;
    public const PHOTO_HEIGHT      = 600;

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const IS_SHOW_ON_HOME = 1;
    public const IS_FEATURED     = 1;

    public function get_blogs(Request $request, array $column = null, bool $all = null, bool $only_active = false): Collection | LengthAwarePaginator
    {
        $query = self::query()->with(['photo', 'categories']);

        if ($column) {
            $query->select($column);
        }

        if ($request->input('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->input('category_id')) {
            $query->whereHas('categories', function ($query) use ($request) {
                $query->where('blog_categories.id', $request->input('category_id'));
            });
        }
        if ($only_active) {
            $query->where('status', '!=', self::STATUS_INACTIVE);
        }
        if ($request->input('sort_order')) {
            $order_direction = $request->input('order_by') ?? 'desc';
            $query->orderBy($request->input('sort_order', 'id'), $order_direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        if ($all) {
            return $query->get();
        }

        return $query->paginate($request->input('per_page', GlobalConstant::DEFAULT_PAGINATION));
    }

    final public function get_active_blog(bool $is_show_on_home = false, bool $is_featured = false): Collection
    {
        $query = self::query()->with(['photo:id,imageable_type,imageable_id,photo', 'created_by:id,name'])->where('status', self::STATUS_ACTIVE)
            ->select('id', 'title', 'slug', 'summary', 'status', 'is_featured', 'is_show_on_home', 'created_at');
        if ($is_show_on_home) {
            $query->where('is_show_on_home', self::IS_SHOW_ON_HOME);
        }
        if ($is_featured) {
            $query->where('is_featured', self::IS_FEATURED);
        }
        return $query->orderBy('id', 'desc')->get();
    }

    public function get_blog($key, $value, $column = null): Blog | Model
    {
        $query = self::query()->with(['photo', 'categories', 'seo', 'created_by']);
        if ($column) {
            $query->select($column);
        }
        return $query->where($key, $value)->firstOrFail();
    }

    final public function get_special_blogs(bool $is_featured = false, bool $is_show_on_home = false, ?int $limit = null): Collection
    {
        $query = self::query()->where('is_featured', self::IS_FEATURED)->with(['photo', 'categories']);
        if ($is_show_on_home) {
            $query->where('is_show_on_home', self::IS_SHOW_ON_HOME);
        }
        if ($is_featured) {
            $query->where('is_featured', self::IS_FEATURED);
        }
        if ($limit) {
            $query->limit($limit);
        }
        return $query->orderBy('id', 'desc')->get();
    }

    final public function increase_click(Blog $blog): void
    {
        $blog->increment('impression');
    }

    private function upload_photo(Request $request, Blog|Model $blog): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($blog->title))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($blog->photo && !empty($blog->photo?->photo)) {
            ImageUploadManager::deletePhoto($blog->photo?->photo);
            $blog->photo->delete();
        }
        $blog->photo()->create($media_data);
    }

    public function prepare_data($request, Blog $blog = null): array
    {
        if ($blog) {
            $data['blog'] = [
                'title'           => $request->input('title') ?? $blog->name,
                'slug'            => $request->input('slug') ?? $blog->slug,
                'content'         => $request->input('content') ?? $blog->content,
                'summary'         => $request->input('summary') ?? $blog->summary,
                'tag'             => $request->input('tag') ?? $blog->tag,
                'status'          => $request->input('status') ?? $blog->status,
                'is_featured'     => $request->input('is_featured') ?? 0,
                'is_show_on_home' => $request->input('is_show_on_home') ?? 0,
                'start_date'      => $request->input('start_date') ?? $blog->start_date,
                'end_date'        => $request->input('end_date') ?? $blog->end_date,
            ];
        } else {
            $data['blog'] = [
                'title'           => $request->input('title'),
                'slug'            => $request->input('slug'),
                'content'         => $request->input('content'),
                'summary'         => $request->input('summary') ?? null,
                'tag'             => $request->input('tag') ?? null,
                'status'          => $request->input('status') ?? self::STATUS_INACTIVE,
                'is_featured'     => $request->input('is_featured') ?? 0,
                'is_show_on_home' => $request->input('is_show_on_home') ?? 0,
                'start_date'      => $request->input('start_date'),
                'end_date'        => $request->input('end_date'),
            ];
        }

        $data['seo']        = (new Seo())->prepare_data($request);
        $data['categories'] = $request->input('categories') ?? [];

        return $data;
    }

    public function store_blog($request): Builder | Model
    {
        $data = $this->prepare_data($request);
        $blog = $this->create($data['blog']);
        $seo  = $blog->seo()->create($data['seo']);
        $blog->categories()->sync($data['categories']);

        $this->upload_photo($request, $blog);
        $seo->upload_photo($request, $seo);

        return $blog;
    }

    public function update_blog($request, Blog $blog): bool
    {
        $data = $this->prepare_data($request, $blog);
        $blog->update($data['blog']);
        $seo = $blog->seo;
        $seo->update($data['seo']);
        $blog->categories()->sync($data['categories']);

        $this->upload_photo($request, $blog);
        $seo->upload_photo($request, $seo, self::PHOTO_UPLOAD_PATH);
        return true;
    }

    public function delete_blog(Blog $blog): bool
    {
        if ($blog->photo) {
            ImageUploadManager::deletePhoto($blog->photo?->photo);
            $blog->photo->delete();
        }
        if ($blog->seo?->photo) {
            ImageUploadManager::deletePhoto($blog->seo?->photo?->photo);
            $blog->seo?->photo?->delete();
        }
        $blog->categories()->detach();
        $blog->seo?->delete();
        $blog->delete();
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
     * @return BelongsToMany
     */
    final public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_category_pivot', 'blog_id', 'blog_category_id');
    }

    /**
     * @return MorphOne
     */
    final public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
