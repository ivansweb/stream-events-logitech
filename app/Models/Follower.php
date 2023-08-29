<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'follower_id',
        'created_at',
    ];

    /**
     *
     * @return BelongsTo
     */
    public function followedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     *
     * @return BelongsTo
     */
    public function followerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
