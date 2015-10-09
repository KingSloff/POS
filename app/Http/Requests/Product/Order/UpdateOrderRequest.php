<?php

namespace App\Http\Requests\Product\Order;

use App\Http\Requests\Request;

class UpdateOrderRequest extends Request
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
            'amount' => 'required|integer|min:1',
            'cost' => 'required|numeric|min:0.001'
        ];
    }
}
