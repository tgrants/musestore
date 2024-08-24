<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pieces()
    {
        return $this->belongsToMany(Piece::class);
    }
}
