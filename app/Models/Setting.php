<?php

namespace App\Models;

use App\Manager\Constants\GlobalConstant;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 2;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    public const TYPE_WEB_DECORATION  = 1;
    public const TYPE_WEB_CREDENTIALS = 2;

    public const TYPE_LIST = [
        self::TYPE_WEB_DECORATION  => 'Web Decoration',
        self::TYPE_WEB_CREDENTIALS => 'Web Credentials',
    ];

    final public function get_settings(Request $request, ?int $type = null, bool $all = false): Collection | LengthAwarePaginator
    {
        $query = self::query();
        if ($request->input('search')) {
            $query->where('key', 'like', '%' . $request->search . '%');
        }
        if ($request->input('order_by_column')) {
            $order_direction = $request->input('order_by') ?? 'desc';
            $query->orderBy($request->input('order_by_column', 'id'), $order_direction);
        } else {
            $query->orderBy('id', 'desc');
        }
        if ($type) {
            $query->where('type', $type);
        }
        if ($all) {
            return $query->get();
        }
        return $query->paginate($request->per_page ?? GlobalConstant::DEFAULT_PAGINATION);
    }

    final static function get_setting(array $key): array
    {
        $cache_key = 'settings' . implode('_', $key);
        if (Cache::has($cache_key)) {
            return Cache::get($cache_key);
        }
        $setting = self::whereIn('key', $key)->get()->pluck('value', 'key')->toArray();
        Cache::put($cache_key, $setting, GlobalConstant::CACHE_EXPIRY);

        return $setting;
    }

    private function prepare_data(Request $request): array
    {
        return [
            'key'    => Str::slug($request->input('key')),
            'value'  => $request->input('value'),
            'type'   => $request->input('type'),
            'status' => $request->input('status'),
        ];
    }

    public function store_setting(Request $request): Builder | Model
    {
        return self::create($this->prepare_data($request));
    }

    public function update_setting(Request $request, Setting $setting): Builder | Model
    {
        $setting->update($this->prepare_data($request));
        return $setting;
    }

    public function delete_setting(Setting $setting): bool
    {
        return $setting->delete();
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
