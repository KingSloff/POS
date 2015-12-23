<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class LoanUserRequest extends Request
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
            'amountToLoan' => 'required|numeric|min:0.01',
        ];
    }
}
