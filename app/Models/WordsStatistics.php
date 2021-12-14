<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordsStatistics extends Model
{
    use HasFactory;

    // TODO:
    protected $table = 'words_practice_statistics';
    protected $guarded = ['id'];
    protected $casts = [
        'created_at' => 'datetime'
    ];

}
