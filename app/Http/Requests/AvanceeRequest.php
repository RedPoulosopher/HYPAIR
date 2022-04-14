<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AvanceeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'projet_id' => 'bail|required|integer',
            'date_publication' => 'bail|required|date:Y-m-d',
            'description' => 'bail|required|string',
        ];
    }
}
