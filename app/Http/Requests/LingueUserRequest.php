<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LingueUserRequest extends FormRequest
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
            'linguaParlata' =>  [
                            'required',
                            'not_in:Seleziona...',
                             Rule::unique('lingueuser', 'lingua_id')
                                ->where('user_id', $this->user_id)
                        ]
        ];
    }

    public function messages()
    {
        return [
            'linguaParlata.required' => 'Devi selezionare una lingua',
            'linguaParlata.not_in' => 'Devi selezionare una lingua',
            'unique' => 'Questa lingua è stata già inserita per questo utente',
        ];
    }
}
