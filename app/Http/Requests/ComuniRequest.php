<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class ComuniRequest extends FormRequest
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
        $id = $this->route()->comuni;

        $ret = [
            'nomeComune' => ['required', 'max:50'],
            'indirizzoComune' => 'required|max:255',
            'caricaLogo' => 'mimes:jpg,jpeg,bmp,png|max:1500',
            'capComune' => 'required|max:5',
            'nomeResponsabile' => 'max:60',
            'numeroTelefono' => 'max:20'
        ];
        if($id)
        {
            $ret ['nomeComune'][] = Rule::unique('comuni', 'nomecomune')->ignore($id);
        } else {
            $ret ['nomeComune'][] = Rule::unique('comuni', 'nomecomune');

        }
        return $ret;
    }
}
