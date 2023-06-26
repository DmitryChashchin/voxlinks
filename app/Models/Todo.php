<?php

namespace App\Models;

use App\Traits\HasLogo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Todo extends Model
{
    use HasFactory, HasLogo;

    protected $fillable = [
        'user_id',
        'title',
        'logo',
        'is_completed',
    ];

    public function path()
    {
        return "/tasks/{$this->id}";
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }
}
