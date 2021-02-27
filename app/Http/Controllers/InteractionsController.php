<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionsController {
    public function create($id, Request $request){
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

        return response()->json([
            'profile_id' => $interaction->profile_id,
            'type' => $interaction->type,
            'action_at' => $interaction->action_at,
            'address_geo' => $interaction->address_geo,
            'outcome' => $interaction->outcome
        ]);
    }
}
