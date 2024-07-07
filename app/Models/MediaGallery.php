<?php

namespace App\Models;

use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaGallery extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

    public const TYPE_NID            = 10;
    public const TYPE_TIN            = 11;
    public const TYPE_TRADE_LICENSE  = 12;
    public const TYPE_BANK_STATEMENT = 13;
    public const TYPE_ATTACHMENT     = 14;
    public const TYPE_VENDOR_GALLERY = 15;
    public const TYPE_CV             = 16;

    public const TYPE_LIST = [
        self::TYPE_NID            => 'NID',
        self::TYPE_TIN            => 'TIN',
        self::TYPE_TRADE_LICENSE  => 'Trade License',
        self::TYPE_BANK_STATEMENT => 'Bank Statement',
        self::TYPE_ATTACHMENT     => 'Attachment',
        self::TYPE_VENDOR_GALLERY => 'Vendor Gallery',
        self::TYPE_CV             => 'CV',
    ];

    /**
     * @param int $id
     * @return Model|null
     */
    final public function get_media_by_id(int $id): Model|null
    {
        return self::query()->where('id', $id)->first();
    }

    final public function imageable(): MorphTo
    {
        return $this->morphTo();
    }


    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable')->orderByDesc('id');
    }


}
