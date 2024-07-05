<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstant;
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
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/post-photos/';

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const IS_FACEBOOK  = 1;
    public const IS_TWITTER   = 1;
    public const IS_LINKEDIN  = 1;
    public const IS_INSTAGRAM = 1;

    public const SOCIAL_LIST = [
        'Facebook',
        'Twitter',
        'Linkedin',
        'Instagram',
    ];

    public function get_posts(Request $request, array $column = null, bool $all = null): Collection | LengthAwarePaginator
    {
        $query = self::query()->with(['photo']);

        if ($column) {
            $query->select($column);
        }

        if ($request->input('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->input('search') . '%')
                    ->orWhere('description', 'like', '%' . $request->input('search') . '%');
            });
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('order_by_column')) {
            $order_direction = $request->input('order_by') ?? 'desc';
            $query->orderBy($request->input('order_by_column', 'id'), $order_direction);
        } else {
            $query->orderBy('id', 'desc');
        }

        if ($all) {
            return $query->get();
        }

        return $query->paginate(GlobalConstant::DEFAULT_PAGINATION);
    }

    private function upload_photo(Request $request, Post|Model $post): void
    {
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($post->title ?? 'post_' . $post->id))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(false)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => null,
        ];
        if ($post->photo && !empty($post->photo?->photo)) {
            ImageUploadManager::deletePhoto($post->photo?->photo);
            $post->photo->delete();
        }
        $post->photo()->create($media_data);
    }

    public function prepare_data(Request $request, Post|Model $post = null): array
    {
        return [
            'title'             => $request->input('title'),
            'description'       => $request->input('description'),
            'status'            => $request->input('status', self::STATUS_INACTIVE),
            'is_facebook'       => $request->input('is_facebook', 0),
            'is_twitter'        => $request->input('is_twitter', 0),
            'is_linkedin'       => $request->input('is_linkedin', 0),
            'is_instagram'      => $request->input('is_instagram', 0),
            'is_post_immediate' => $request->input('is_post_immediate', 0),
            'post_time'         => $request->input('post_time') ?? now()->format('Y-m-d H:i:s'),
        ];
    }

    final public function store_post(Request $request): Post
    {
        $data = $this->prepare_data($request);
        $post = self::create($data);
        $this->upload_photo($request, $post);

        return $post;
    }

    final public function delete_post(Post $post): bool
    {
        if ($post->photo && !empty($post->photo->photo)) {
            ImageUploadManager::deletePhoto($post->photo->photo);
            $post->photo->delete();
        }

        return $post->delete();
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
