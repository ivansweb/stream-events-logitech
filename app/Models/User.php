<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'social_id',
        'social_type',
        'last_login',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'social_id',
        'created_at',
        'updated_at',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all subscribers for this user.
     *
     * @return HasMany
     */
    public function subscribers(): HasMany
    {
        return $this->hasMany(Subscriber::class, 'user_id');
    }

    /**
     * Get all followers for this user.
     *
     * @return HasMany
     */
    public function followers(): HasMany
    {
        return $this->hasMany(Follower::class, 'user_id');
    }

    /**
     * Get all donations for this user.
     *
     * @return HasMany
     */
    public function donations(): HasMany
    {
        return $this->hasMany(Donation::class, 'user_id');
    }

    /**
     * Get all merch sales for this user.
     *
     * @return HasMany
     */
    public function merchSales(): HasMany
    {
        return $this->hasMany(MerchSale::class, 'user_id');
    }

}
