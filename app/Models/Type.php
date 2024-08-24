<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false;

    use HasFactory;

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
