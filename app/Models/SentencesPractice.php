<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @param int $id
 * @param int $library_id
 * @param int $count_words
 * @param int $count_wrong
 * @param int $count_true
 * @param array $result
 */
class SentencesPractice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = true;

    protected $table = 'sentences_practices_statistics';

    protected $casts = [
        'created_at' => 'datetime',
        'result' => 'json'
    ];
}
