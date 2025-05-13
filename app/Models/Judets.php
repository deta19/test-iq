<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Judets extends Model
{
    use HasFactory;

    protected $fillable = ['nume', 'cod'];

    public function orase()
    {
        return $this->hasMany(Orase::class);
    }
}
