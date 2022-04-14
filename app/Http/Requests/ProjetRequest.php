<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjetRequest extends FormRequest
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
            'association_id' => 'bail|required|integer',
            'confidentialite' => 'bail|required|boolean',
            'titre' => 'bail|required|string',
            'projet_id' => 'bail|required|integer',
            'description_courte' => 'bail|required|string',
            'chef_projet' => 'bail|nullable|string',
            'date_creation'=>'bail|required|date'
        ];
    }
}
