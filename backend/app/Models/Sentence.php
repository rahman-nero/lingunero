<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sentence extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = true;

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
