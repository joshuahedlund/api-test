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

    public static function boot() {
        parent::boot();

        static::deleting(function(Profile $profile) {
            $profile->interactions()->delete();
        });
    }

    public function interactions(){
        return $this->hasMany(Interaction::class);
    }

    /**
     * Returns the number of total profile records (should be valid int)
     * @return mixed
     */
    public static function count(){
        return DB::table('profiles')->selectRaw('count(id) as cnt')->first()->cnt;
    }

    /**
     * Returns the list of records
     * @param $args
     *  includeInteractions - include a multi-dim array of interactions associated with the profiles
     *  all - return all results in a single page
     *  page - return results for a specific page of results (default value: 1)
     * @return mixed
     */
    public static function get($args){
        $db = DB::table('profiles as p');

        if(array_key_exists('includeInteractions',$args)){
            $db = $db->leftJoin('interactions as i','i.profile_id','=','p.id')
                ->selectRaw("p.*, IF(i.id>0,json_arrayagg(json_object('type',i.type,'action_at',i.action_at,'outcome',i.outcome,'address_geo',i.address_geo)),null) AS interactions");
        }else{
            $db = $db->select('p.*');
        }

        $db = $db->groupBy('p.id');
        $db = $db->orderBy('p.id');

        if(!array_key_exists('all',$args)){
            $offset = isset($args['page']) ? ($args['page'] - 1) * 10 : 0;
            $db = $db->limit(10)->offset($offset);
        }
        return $db->get();
    }
}
