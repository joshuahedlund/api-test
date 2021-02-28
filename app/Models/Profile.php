<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'apt',
        'city',
        'state',
        'zip',
        'phone',
        'mobile',
        'email',
        'address_geo'
    ];

    public function interactions(){
        return $this->hasMany(Interaction::class);
    }

    public static function getWithInteractions(){
        return DB::table('profiles as p')
            ->leftJoin('interactions as i','i.profile_id','=','p.id')
            ->selectRaw("p.*, IF(i.id>0,json_arrayagg(json_object('type',i.type,'action_at',i.action_at,'outcome',i.outcome,'address_geo',i.address_geo)),null) AS interactions")
            ->groupBy('p.id')
            ->get();
    }
}
