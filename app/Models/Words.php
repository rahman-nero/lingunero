<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @param int $id
 * @param int $library_id
 * @param string $word
 * @param string $translation
 * @param string $description
 * @param Carbon $created_at
 * @param Carbon $updated_at
 */
class Words extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime'
    ];

    public function examples()
    {
        return $this->hasMany(WordExample::class, 'word_id', 'id');
    }

    public function isFavorite(): bool
    {
        return FavoriteWords::query()
            ->where('word_id', '=', $this->id)
            ->where('user_id', '=', Auth::id())
            ->get()
            ->isNotEmpty();
    }

}
