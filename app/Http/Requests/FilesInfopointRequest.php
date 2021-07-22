<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilesInfopointRequest extends FormRequest
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
            'gruppoFile' => 'required|not_in:Seleziona...',
            'accessoFile' => 'required|not_in:Seleziona...',
            'caricaFileInfopoint' => 'required|mimes:jpg,jpeg,bmp,png,doc,docx,xls,xlsx,pdf|max:2500'
       ];
    }
}