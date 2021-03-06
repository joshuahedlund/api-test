<?php

namespace App\Http\Requests;

class ProfileCreateRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //todo more specific formatting validation where applicable
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'address' => 'max:255',
            'apt' => 'max:255',
            'city' => 'max:255',
            'state' => 'max:2',
            'zip' => 'max:10',
            'phone' => 'max:16',
            'mobile' => 'max:16',
            'email' => 'email|max:255',
            'address_geo' => 'max:255',
        ];
    }
}
