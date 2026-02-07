<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * User statistics for grammar practice.
 *
 * @property int $id
 * @property int $grammary_id
 * @property int $user_id
 * @property array|null $statistic
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class GrammaryPracticeStatistic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'statistic' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function grammary()
    {
        return $this->belongsTo(Grammary::class, 'grammary_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
