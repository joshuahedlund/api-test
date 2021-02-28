<?php

namespace App\Exceptions;

use Mockery\Exception;

class InteractionNotFoundException extends Exception
{
    public function render(){
        return response()->json([
            'error' => 'Interaction not found'
        ]);
    }
}
