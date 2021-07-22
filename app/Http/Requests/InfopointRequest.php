<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InfopointRequest extends FormRequest
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
             'inputIndirizzo' => 'required|max:255',
             'cap' => 'required|max:5',
             'inputLatitudine' => 'required|max:40',
             'inputLongitudine' => 'required|max:40',
             'caricaImg' => 'mimes:jpg,jpeg,bmp,png|max:1500',
        ];
    }
}
