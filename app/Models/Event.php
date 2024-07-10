<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstant;
use App\Manager\ImageUploadManager;
use App\Manager\Utility\Formatter;
use App\Manager\Utility\Utility;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Contracts\Database\Eloquent\Builder;
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

class Event extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/event-photos/';

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const IS_SHOW_ON_HOME = 1;
    public const IS_FEATURED     = 1;

    public function get_events(Request $request, array $column = null, bool $all = null, bool $only_active = false): Collection | LengthAwarePaginator
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

    final public function get_active_event(bool $is_show_on_home = false, bool $is_featured = false): Collection
    {
        $query = self::query()->with(['photo:id,imageable_type,imageable_id,photo'])->where('status', self::STATUS_ACTIVE)
            ->select('id', 'title', 'slug', 'summary', 'status', 'is_featured', 'is_show_on_home', 'start_date', 'end_date');
        if ($is_show_on_home) {
            $query->where('is_show_on_home', self::IS_SHOW_ON_HOME);
        }
        if ($is_featured) {
            $query->where('is_featured', self::IS_FEATURED);
        }
        return $query->orderBy('id', 'desc')->get();
    }

    public function get_event($key, $value, $column = null): Event | Model
    {
        $query = self::query()->with(['photo', 'categories', 'seo', 'created_by']);
        if ($column) {
            $query->select($column);
        }
        return $query->where($key, $value)->firstOrFail();
    }

    final public function get_special_events(bool $is_featured = false, bool $is_show_on_home = false, ?int $limit = null): Collection
    {
        $query = self::query()->with(['photo', 'categories']);
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

    final public function get_upcoming_events(int $limit = 5): ?Collection
    {
        return self::query()->with(['photo', 'categories'])
            ->where('status', self::STATUS_ACTIVE)
            ->where('start_date', '>', now())
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();
    }

    final public function get_related_event(Event $event, int $limit = 8): Collection
    {
        return self::query()->with(['photo', 'categories'])
            ->where('status', self::STATUS_ACTIVE)
            ->where('id', '!=', $event->id)
            ->whereHas('categories', function ($query) use ($event) {
                $query->whereIn('event_category_id', $event->categories->pluck('id')->toArray());
            })
            ->orderBy('id', 'desc')
            ->limit($limit)
            ->get();
    }

    final public function increase_click(Event $event): void
    {
        $event->increment('impression');
    }

    private function upload_photo(Request $request, Event|Model $event): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($event->title))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($event->photo && !empty($event->photo?->photo)) {
            ImageUploadManager::deletePhoto($event->photo?->photo);
            $event->photo->delete();
        }
        $event->photo()->create($media_data);
    }

    public function prepare_data($request, Event $event = null): array
    {
        if ($event) {
            $data['event'] = [
                'title'           => $request->input('title') ?? $event->name,
                'slug'            => $request->input('slug') ?? $event->slug,
                'content'         => $request->input('content') ?? $event->content,
                'summary'         => $request->input('summary') ?? $event->summary,
                'video_url'       => Formatter::youtube_url_format($request->input('video_url')),
                'tag'             => $request->input('tag') ?? $event->tag,
                'status'          => $request->input('status') ?? $event->status,
                'is_featured'     => $request->input('is_featured') ?? 0,
                'is_show_on_home' => $request->input('is_show_on_home') ?? 0,
                'start_date'      => $request->input('start_date') ?? $event->start_date,
                'end_date'        => $request->input('end_date') ?? $event->end_date,
            ];
        } else {
            $data['event'] = [
                'title'           => $request->input('title'),
                'slug'            => $request->input('slug'),
                'content'         => $request->input('content'),
                'summary'         => $request->input('summary') ?? null,
                'video_url'       => Formatter::youtube_url_format($request->input('video_url')),
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

    public function store_event($request): Builder | Model
    {
        $data = $this->prepare_data($request);
        $event = $this->create($data['event']);
        $seo  = $event->seo()->create($data['seo']);
        $event->categories()->sync($data['categories']);

        $this->upload_photo($request, $event);
        $seo->upload_photo($request, $seo);

        return $event;
    }

    public function update_event($request, Event $event): bool
    {
        $data = $this->prepare_data($request, $event);
        $event->update($data['event']);
        $seo = $event->seo;
        $seo->update($data['seo']);
        $event->categories()->sync($data['categories']);

        $this->upload_photo($request, $event);
        $seo->upload_photo($request, $seo, self::PHOTO_UPLOAD_PATH);
        return true;
    }

    public function delete_event(Event $event): bool
    {
        if ($event->photo) {
            ImageUploadManager::deletePhoto($event->photo?->photo);
            $event->photo->delete();
        }
        if ($event->seo?->photo) {
            ImageUploadManager::deletePhoto($event->seo?->photo?->photo);
            $event->seo?->photo?->delete();
        }
        $event->categories()->detach();
        $event->seo?->delete();
        $event->delete();
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
        return $this->belongsToMany(EventCategory::class, 'event_category_pivot', 'event_id', 'event_category_id');
    }

    /**
     * @return MorphOne
     */
    final public function seo(): MorphOne
    {
        return $this->morphOne(Seo::class, 'seoable');
    }
}
