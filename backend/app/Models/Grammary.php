<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Grammar topic.
 *
 * @property int $id
 * @property string $name
 * @property string|null $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Grammary extends Model
{
    use HasFactory;

    protected $table = 'grammary';

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function practices()
    {
        return $this->hasMany(GrammaryPractice::class, 'grammary_id', 'id');
    }

    public function practiceStatistics()
    {
        return $this->hasMany(GrammaryPracticeStatistic::class, 'grammary_id', 'id');
    }
}
