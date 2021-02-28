<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
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

    public static function count(){
        return DB::table('profiles')->selectRaw('count(id) as cnt')->first()->cnt;
    }

    public static function get(Request $request){
        $db = DB::table('profiles as p');

        if($request->has('includeInteractions')){
            $db = $db->leftJoin('interactions as i','i.profile_id','=','p.id')
                ->selectRaw("p.*, IF(i.id>0,json_arrayagg(json_object('type',i.type,'action_at',i.action_at,'outcome',i.outcome,'address_geo',i.address_geo)),null) AS interactions");
        }else{
            $db = $db->select('p.*');
        }

        $db = $db->groupBy('p.id');
        $db = $db->orderBy('p.id');

        if(!$request->has('all')){
            $offset = is_numeric($request->page) ? ((int)$request->page - 1) * 10 : 0;
            $db = $db->limit(10)->offset($offset);
        }
        return $db->get();
    }
}
