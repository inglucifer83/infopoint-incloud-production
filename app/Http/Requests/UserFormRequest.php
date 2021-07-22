<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'inputName' => 'required|string|max:255',
            'inputEmail' => ['required',
                            'string',
                            'email',
                            'max:255',
                            Rule::unique('users', 'email')->ignore($this->userid, 'id')],
            'tipoRuolo' => 'required|not_in:Seleziona...',
            'caricaImg' => 'mimes:jpg,jpeg,bmp,png|max:1500',
            'password' => ['min:8',
                           Password::defaults()],
            'confermaPassword' => 'same:old_email'
        ];
    }
}

/*
'password' => [
                'required', 
                'confirmed', 
                Password::defaults()]
*/