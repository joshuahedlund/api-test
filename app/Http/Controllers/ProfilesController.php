<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class ProfilesController {
    public function create(Request $request){
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

    public function update($id, Request $request){
        $profile = Profile::find($id);

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

    public function delete($id){
        Profile::destroy([$id]);

        return response()->json([
            'success' => true
        ]);
    }

    public function show($id){
        $profile = Profile::find($id);

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
        if($request->has('includeInteractions')){
            $profiles = Profile::getWithInteractions()->toArray();
            $profiles = array_map(function($profile){
                $profile->interactions = json_decode('['.$profile->interactions.']');
                return $profile;
            }, $profiles);
        }else {
            $profiles = Profile::all()->toArray();
        }

        return response()->json($profiles);
    }
}
