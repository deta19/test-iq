<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orase extends Model
{
     use HasFactory;

    protected $fillable = [
        'nume',
        'judet_id',
        'coord_x',
        'coord_y',
        'populatie',
        'regiune',
    ];

    public function judets()
    {
        return $this->belongsTo(Judet::class);
    }
}
