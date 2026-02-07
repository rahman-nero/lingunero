<?php

namespace App\Models;

use App\Enums\GrammaryPracticeTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Grammar practice question.
 * 
 * @property int $id
 * @property int $grammary_id
 * @property string $union_id
 * @property string|null $title
 * @property string|null $type
 * @property string|null $question
 * @property array|null $answers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class GrammaryPractice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'type' => GrammaryPracticeTypeEnum::class,
        'answers' => 'array',
    ];

    public function grammary()
    {
        return $this->belongsTo(Grammary::class, 'grammary_id', 'id');
    }
}
