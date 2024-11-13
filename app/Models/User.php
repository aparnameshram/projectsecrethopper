<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public const DEFAULT_ROLE_ID = 3;

    protected $appends = ['isAdmin'];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    public function venues(): HasMany
    {
        return $this->hasMany(venue::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class); //->withPivot('claimed_timeslot_id');
    }

    public function attachedTimeslots(): BelongsToMany
    {
        return $this->belongsToMany(Timeslot::class, 'group_user', 'user_id', 'claimed_timeslot_id');
    }

    public function Role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdministrator()
    {
        return ($this->role->name == 'admin');
    }

    public function getIsAdminAttribute()
    {
        return $this->isAdministrator();
    }
}
