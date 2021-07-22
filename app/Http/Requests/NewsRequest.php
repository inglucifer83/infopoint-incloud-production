<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            'inputTitolo' => 'required|max:255',
            'inputDescrizione' => 'required',
            'caricaFile' => 'mimes:jpg,jpeg,bmp,png,pdf,doc,docx,xls,xlsx|max:1500',
            'tipoNews' => 'required|not_in:Seleziona...'
       ];
    }
}
