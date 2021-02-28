<?php

namespace App\Http\Controllers;

use App\Exceptions\InteractionNotFoundException;
use App\Exceptions\ProfileNotFoundException;
use App\Http\Requests\InteractionCreateRequest;
use App\Models\Interaction;
use App\Models\Profile;

class InteractionsController {
    public function create($id, InteractionCreateRequest $request){
        //Validate profile
        $profile = Profile::find($id);
        if(empty($profile))
            throw new ProfileNotFoundException();

        //Create interaction
        $interaction = new Interaction();

        $interaction->profile_id = $id;

        foreach($interaction->getFillable() as $field){
            if(!empty($request->$field)){
                $interaction->$field = $request->$field;
            }
        }
        $interaction->save();

        return response()->json([
            'success' => true,
            'id' => $interaction->id,
        ]);
    }

    public function show($id){
        $interaction = Interaction::find($id);

        if(empty($interaction))
            throw new InteractionNotFoundException();

        return response()->json([
            'profile_id' => $interaction->profile_id,
            'type' => $interaction->type,
            'action_at' => $interaction->action_at,
            'address_geo' => $interaction->address_geo,
            'outcome' => $interaction->outcome
        ]);
    }
}
