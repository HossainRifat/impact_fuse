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

class Inquiry extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const STATUS_ACTIVE   = 1;
    public const STATUS_INACTIVE = 2;
    public const STATUS_NEW      = 3;
    public const STATUS_SEEN     = 4;

    public const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_NEW      => 'New',
        self::STATUS_SEEN     => 'Seen',
    ];

    final public function get_inquiries(Request $request): LengthAwarePaginator
    {
        $query = self::query();
        if ($request->input('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                ->orWhere('email', 'like', '%' . $request->input('search') . '%')
                ->orWhere('phone', 'like', '%' . $request->input('search') . '%')
                ->orWhere('subject', 'like', '%' . $request->input('search') . '%')
                ->orWhere('message', 'like', '%' . $request->input('search') . '%')
                ->orWhere('route', 'like', '%' . $request->input('search') . '%')
                ->orWhere('ip', 'like', '%' . $request->input('search') . '%');
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

        return $query->paginate($request->input('per_page', GlobalConstant::DEFAULT_PAGINATION));
    }

    private function prepare_data(Request $request, ?Inquiry $inquiry = null): array
    {
        if ($inquiry) {
            $data = [
                'name'    => $request->input('name') ?? $inquiry->name,
                'email'   => $request->input('email') ?? $inquiry->email,
                'phone'   => $request->input('phone') ?? $inquiry->phone,
                'subject' => $request->input('subject') ?? $inquiry->subject,
                'message' => $request->input('message') ?? $inquiry->message,
                'route'   => $request->input('route') ?? $inquiry->route,
                'ip'      => $request->input('ip') ?? $inquiry->ip,
                'status'  => $request->input('status') ?? $inquiry->status,
            ];
        } else {
            $data = [
                'name'    => $request->input('name'),
                'email'   => $request->input('email'),
                'phone'   => $request->input('phone'),
                'subject' => $request->input('subject'),
                'message' => $request->input('message'),
                'route'   => $request->input('route'),
                'ip'      => $request->ip(),
                'status'  => self::STATUS_NEW,
            ];
        }

        return $data;
    }

    final public function store_inquiry(Request $request): Builder | Model
    {
        return self::query()->create($this->prepare_data($request));
    }

    final public function update_inquiry(Request $request, Inquiry $inquiry): Builder | Model
    {
        $inquiry->update($this->prepare_data($request, $inquiry));

        return $inquiry;
    }

    final public function delete_inquiry(Inquiry $inquiry): bool
    {
        return $inquiry->delete();
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
