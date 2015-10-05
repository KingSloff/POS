<?php

namespace App\Http\Requests\Product\Stock;

use App\Http\Requests\Request;

class CreateStockEntryRequest extends Request
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
            'amount' => 'integer|min:1',
            'cost' => 'numeric|min:0.001'
        ];
    }
}
