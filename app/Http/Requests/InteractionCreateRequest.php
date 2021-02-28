<?php

namespace App\Http\Requests;

class InteractionCreateRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'in:in-person,email,phone,sms',
            'outcome' => 'in:contacted,not home,no answer,no response',
            'action_at' => 'date',
            'address_geo' => 'max:255',
        ];
    }
}
