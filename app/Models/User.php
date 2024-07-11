<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Manager\ImageUploadManager;
use App\Manager\Utility\Utility;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use App\Manager\Constants\GlobalConstant;
use App\Manager\FileUploadManager;
use App\Models\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const DEFAULT_PASSWORD = '12345678';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */

    public const STATUS_INACTIVE  = 6;
    public const STATUS_ACTIVE    = 1;
    public const STATUS_SUSPENDED = 2;
    public const STATUS_BLOCKED   = 3;
    public const STATUS_PENDING   = 4;
    public const STATUS_REJECTED  = 5;

    public const STATUS_LIST = [
        self::STATUS_INACTIVE  => 'Inactive',
        self::STATUS_ACTIVE    => 'Active',
        self::STATUS_SUSPENDED => 'Suspended',
        self::STATUS_BLOCKED   => 'Blocked',
        self::STATUS_PENDING   => 'Pending',
        self::STATUS_REJECTED  => 'Rejected',
    ];

    public const PHOTO_UPLOAD_PATH = 'public/photos/uploads/user-photos/';
    public const FILE_UPLOAD_PATH  = 'user-cv';
    public const PHOTO_WIDTH       = 600;
    public const PHOTO_HEIGHT      = 600;

    public const IMAGE_TYPE_PROFILE = 1;
    public const IMAGE_TYPE_COVER = 2;
    public const IMAGE_TYPE_NID_FRONT = 3;
    public const IMAGE_TYPE_NID_BACK = 4;

    public const IMAGE_TYPE_LIST = [
        self::IMAGE_TYPE_PROFILE   => 'Profile photo',
        self::IMAGE_TYPE_COVER     => 'Cover photo',
        self::IMAGE_TYPE_NID_FRONT => 'NID front side',
        self::IMAGE_TYPE_NID_BACK  => 'NID back side'
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }


    final public function get_admins(Request $request, array|null $columns = null): LengthAwarePaginator
    {
        $query = self::query()->with('roles');

        if ($columns) {
            $query->select($columns);
        }

        if ($request->input('name')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('name') . '%')
                    ->orWhere('email', 'like', '%' . $request->input('name') . '%')
                    ->orWhere('phone', 'like', '%' . $request->input('name') . '%');
            });
        }
        if ($request->input('phone')) {
            $query->where('phone', $request->input('phone'));
        }
        if ($request->input('email')) {
            $query->where('email', $request->input('email'));
        }
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('role')) {
            $query->whereHas('roles', function ($query) use ($request) {
                $query->where('id', $request->input('role'));
            });
        }
        if ($request->input('department')) {
            $query->where('department', 'like', '%' . $request->input('department') . '%');
        }
        if ($request->input('designation')) {
            $query->where('designation', 'like', '%' . $request->input('designation') . '%');
        }
        if ($request->input('start_date')) {
            $query->whereDate('start_date', '>=', $request->input('start_date'));
        }
        if ($request->input('end_date')) {
            $query->whereDate('end_date', '<=', $request->input('end_date'));
        }
        if ($request->input('responsibility')) {
            $query->where('responsibility', 'like', '%' . $request->input('responsibility') . '%');
        }
        if ($request->input('order_by_column')) {
            $direction = $request->input('order_by', 'desc');
            $query->orderBy($request->input('order_by_column', 'id'), $direction);
        }
        return $query->paginate($request->input('per_page', GlobalConstant::DEFAULT_PAGINATION));
    }

    final public function get_active_members(): Collection
    {
        return self::query()->where('status', self::STATUS_ACTIVE)->with('profile_photo')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Volunteer');
            })
            ->orderBy('sort_order', 'desc')->get();
    }

    final public function get_user_by_id(int $user_id)
    {
        return self::query()->find($user_id);
    }


    /**
     * @param Request $request
     * @return Collection|Model|null
     * @throws Exception
     */
    final public function update_own_profile(Request $request): Collection|Model|null
    {
        $user = self::query()->with('profile_photo')->findOrFail(Auth::id());
        if ($user) {
            $user->update([
                'name'  => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            if ($request->has('photo')) {
                $this->upload_profile_photo($request, $user);
            }
        }
        return $user;
    }

    /**
     * @return MorphOne
     */
    final public function profile_photo(): MorphOne
    {
        return $this->morphOne(MediaGallery::class, 'imageable')
            ->where('type', self::IMAGE_TYPE_PROFILE)
            ->orderByDesc('id');
    }

    /**
     * @return MorphOne
     */
    final public function cv(): MorphOne
    {
        return $this->morphOne(MediaGallery::class, 'imageable')
            ->where('type', MediaGallery::TYPE_CV);
    }

    /**
     * @throws Exception
     */
    private function upload_profile_photo(Request $request, User|Model $user): void
    {
        Cache::forget('admin_profile_photo');
        $file = $request->file('photo');
        if (is_string($request->input('photo'))) {
            $file = Storage::get($request->input('photo'));
        }
        if (!$file) {
            return;
        }
        $photo      = (new ImageUploadManager)->file($file)
            ->name(Utility::prepare_name($user->name))
            ->path(self::PHOTO_UPLOAD_PATH)
            ->auto_size()
            ->watermark(true)
            ->upload();
        $media_data = [
            'photo' => self::PHOTO_UPLOAD_PATH . $photo,
            'type'  => self::IMAGE_TYPE_PROFILE
        ];
        if ($user->profile_photo && !empty($user->profile_photo->photo)) {
            ImageUploadManager::deletePhoto($user->profile_photo->photo);
            $user->profile_photo->delete();
        }
        $user->photo()->create($media_data);
    }

    private function upload_attachment(Request $request, User | Model $user): void
    {
        $fileUploadManager = new FileUploadManager();
        $file = $request->file('cv');
        if (!$file) {
            return;
        }

        if (!empty($user->cv)) {
            $fileUploadManager->delete($user->cv?->photo);
            $user->photos()->where('type', MediaGallery::TYPE_CV)->delete();
        }

        $data = [
            'photo' => $fileUploadManager->file($file)->path(self::FILE_UPLOAD_PATH)->upload(),
            'type'  => MediaGallery::TYPE_CV
        ];

        $user->photo()->create($data);
    }

    private function prepare_data(Request $request, ?User $user = null): array
    {
        $data = [
            'name'              => $request->input('name'),
            'email'             => $request->input('email'),
            'phone'             => $request->input('phone', null),
            'address'           => $request->input('address', null),
            'note'              => $request->input('note', null),
            'status'            => $request->input('status', self::STATUS_ACTIVE),
            'designation'       => $request->input('designation', null),
            'emergency_contact' => $request->input('emergency_contact', null),
            'date_of_birth'     => $request->input('date_of_birth', null),
            'start_date'        => $request->input('start_date', null),
            'end_date'          => $request->input('end_date', null),
            'sort_order'        => $request->input('sort_order', null),
            'department'        => $request->input('department', null),
            'responsibility'    => $request->input('responsibility', null),
        ];
        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        return $data;
    }

    final public function store_user(Request $request): Builder | Model
    {
        $user = self::query()->create($this->prepare_data($request));
        if ($request->input('role_id')) {
            $user->roles()->sync($request->input('role_id'));
        }
        if ($request->has('photo')) {
            $this->upload_profile_photo($request, $user);
        }
        if ($request->has('cv')) {
            $this->upload_attachment($request, $user);
        }

        return $user;
    }


    final public function update_user(Request $request, User $user): Builder|Model
    {
        $user->update($this->prepare_data($request));
        if ($request->input('role_id')) {
            $user->roles()->sync($request->input('role_id'));
        }
        if ($request->has('photo')) {
            $this->upload_profile_photo($request, $user);
        }
        if ($request->has('cv')) {
            $this->upload_attachment($request, $user);
        }
        return $user;
    }

    final public function delete_user(User $user): bool
    {
        if ($user->profile_photo && !empty($user->profile_photo->photo)) {
            ImageUploadManager::deletePhoto($user->profile_photo->photo);
            $user->profile_photo->delete();
        }
        return $user->delete();
    }



    /**
     * @return MorphOne
     */
    final public function photo(): MorphOne
    {
        return $this->morphOne(MediaGallery::class, 'imageable');
    }

    final public function activity_logs(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'logable')->orderByDesc('id');
    }
}
