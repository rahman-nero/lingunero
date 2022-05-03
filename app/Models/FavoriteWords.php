<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $word_id
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 */
class FavoriteWords extends Model
{
    use HasFactory;

    protected $table = 'favorite_words';

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime'
    ];

}
