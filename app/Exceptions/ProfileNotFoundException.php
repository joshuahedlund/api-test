<?php

namespace App\Exceptions;

use Mockery\Exception;

class ProfileNotFoundException extends Exception
{
    public function render(){
        return response()->json([
            'error' => 'Profile not found'
        ]);
    }
}
