<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstant;
use App\Manager\ImageUploadManager;
use App\Manager\Utility\Utility;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/page-photos/';
    public const STATUS_ACTIVE     = 1;
    public const STATUS_INACTIVE   = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const IS_SHOW_ON_HEADER = 1;
    public const IS_SHOW_ON_FOOTER = 1;

    public function get_pages(Request $request, array $column = null, bool $all = null, bool $only_active = false)
    {
        $query = self::query()->with('photo', 'seo');

        if ($column) {
            $query->select($column);
        }

        if ($request->input('search')) {
            $query->where('search', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
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

        if ($only_active) {
            $query->where('status', self::STATUS_ACTIVE);
        }

        return $query->paginate(GlobalConstant::DEFAULT_PAGINATION)->withQueryString();
    }

    private function upload_photo(Request $request, Page|Model $page): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($page->title ?? 'page_' . $page->id))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($page->photo && !empty($page->photo?->photo)) {
            ImageUploadManager::deletePhoto($page->photo?->photo);
            $page->photo->delete();
        }
        $page->photo()->create($media_data);
    }


    private function prepare_data(Request $request)
    {
        $data['page'] = [
            'title'             => $request->input('title'),
            'slug'              => $request->input('slug'),
            'content'           => $request->input('content'),
            'status'            => $request->input('status', self::STATUS_ACTIVE),
            'is_show_on_header' => $request->input('is_show_on_header', 0),
            'is_show_on_footer' => $request->input('is_show_on_footer', 0),
            'display_order'     => $request->input('display_order', null), 
        ];

        $data['seo'] = (new Seo())->prepare_data($request);

        return $data;
    }

    public function store_page(Request $request): Builder | Model
    {
        $prepared_data = $this->prepare_data($request);
        $page          = self::query()->create($prepared_data['page']);
        $seo           = $page->seo()->create($prepared_data['seo']);

        $this->upload_photo($request, $page);
        $seo->upload_photo($request, $seo);

        return $page;
    }

    public function update_page(Request $request, Page $page): Builder | Model
    {
        $prepared_data = $this->prepare_data($request);
        $page->update($prepared_data['page']);
        $page->seo->update($prepared_data['seo']);

        $this->upload_photo($request, $page);
        $page->seo->upload_photo($request, $page->seo);

        return $page;
    }

    final public function increase_click(Page $page): void
    {
        $page->increment('impression');
    }

    public function delete_page(Page $page): bool
    {
        if ($page->photo && !empty($page->photo?->photo)) {
            ImageUploadManager::deletePhoto($page->photo?->photo);
            $page->photo->delete();
        }
        if ($page->seo) {
            if ($page->seo?->photo && !empty($page->seo?->photo?->photo)) {
                ImageUploadManager::deletePhoto($page->seo->photo->photo);
                $page->seo->photo->delete();
            }
            $page->seo->delete();
        }

        return $page->delete();
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
