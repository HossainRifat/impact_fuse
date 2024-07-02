<?php

namespace App\Models;

use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, CreatedUpdatedBy, SoftDeletes;

    protected $guarded = [];

        public const STATUS_ACTIVE = 1;
        public const STATUS_INACTIVE = 2;

        public const STATUS_LIST = [
            self::STATUS_ACTIVE   => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];

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
