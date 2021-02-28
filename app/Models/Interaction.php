<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type',
        'action_at',
        'address_geo',
        'outcome'
    ];

    public function profile(){
        return $this->belongsTo(Profile::class);
    }
}
