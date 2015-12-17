<?php

namespace App\Http\Requests\Cart;

use App\Http\Requests\Request;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required_without:cash|exists:users,id',
            'amountGiven' => 'required_if:cash,on|numeric|min:0.001'
        ];
    }
}
