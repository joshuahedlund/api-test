<?php

namespace App\Http\Controllers;

use App\Exceptions\ProfileNotFoundException;
use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilesController {
    public function create(ProfileCreateRequest $request){
        $profile = new Profile();

        foreach($profile->getFillable() as $field){
            if(!empty($request->$field)){
                $profile->$field = $request->$field;
            }
        }
        $profile->save();

        return response()->json([
            'success' => true,
            'id' => $profile->id,
        ]);
    }

    public function update($id, ProfileUpdateRequest $request){
        $profile = Profile::find($id);

        if(empty($profile))
            throw new ProfileNotFoundException();

        foreach($profile->getFillable() as $field){
            if($request->has($field)){
                $profile->$field = $request->$field;
            }
        }
        $profile->save();

        return response()->json([
            'success' => true,
            'id' => $profile->id,
        ]);
    }

    public function delete($id){
        Profile::destroy([$id]);

        return response()->json([
            'success' => true
        ]);
    }

    public function show($id){
        $profile = Profile::find($id);

        if(empty($profile))
            throw new ProfileNotFoundException();

        return response()->json([
            'id' => $profile->id,
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'address' => $profile->address,
            'apt' => $profile->apt,
            'city' => $profile->city,
            'state' => $profile->state,
            'zip' => $profile->zip,
            'phone' => $profile->phone,
            'mobile' => $profile->mobile,
            'email' => $profile->email,
            'address_geo' => $profile->address_geo
        ]);
    }

    public function index(Request $request){
        $count = Profile::count();

        if($count>0){
            $profiles = Profile::get($request)->toArray();

            //Convert json string result from mysql column into actual json
            if($request->has('includeInteractions')){
                $profiles = array_map(function($profile){
                    $profile->interactions = json_decode('['.$profile->interactions.']');
                    return $profile;
                }, $profiles);
            }
        }else{
            $profiles = [];
        }

        return response()->json([
            'total' => $count,
            'page' => (is_numeric($request->page) ? (int)$request->page : 1),
            'profiles' => $profiles
        ]);
    }
}
