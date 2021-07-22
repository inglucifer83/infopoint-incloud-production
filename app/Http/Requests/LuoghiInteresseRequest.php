<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LuoghiInteresseRequest extends FormRequest
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
            'inputDenominazione' => 'required|max:255',
            'inputIndirizzo' => 'required|max:255',
            'inputLatitudine' => 'required|max:40',
            'inputLongitudine' => 'required|max:40',
            'caricaFile' => 'mimes:jpg,jpeg,bmp,png,pdf|max:1500',
            'caricaImg' => 'mimes:jpg,jpeg,bmp,png|max:1500',
            'tipoLuogo' => 'required|not_in:Seleziona...'
       ];
    }
}
