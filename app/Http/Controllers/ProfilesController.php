<?php

namespace App\Http\Controllers;

use App\Exceptions\ProfileNotFoundException;
use App\Http\Requests\ProfileCreateRequest;
use App\Http\Requests\ProfileListRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;

class ProfilesController {

    /**
     * Store a new profile instance
     * @param ProfileCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Update an existing profile instance
     * @param $id
     * @param ProfileUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Delete a profile instance
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id){
        Profile::destroy([$id]);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Return a profile instance
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * List profile instances
     * Default behavior returns a limited page of records with top-level data, sorted by id. Query parameters can adjust output (see Profile::get)
     * @param ProfileListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProfileListRequest $request){
        $count = Profile::count();

        if($count>0){
            $args = $request->only(['includeInteractions','all','page']);

            $profiles = Profile::get($args)->toArray();

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
            'page' => ($request->has('page') ? $request->page : 1),
            'profiles' => $profiles
        ]);
    }
}
