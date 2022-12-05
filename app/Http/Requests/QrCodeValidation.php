<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrCodeValidation extends FormRequest
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
            'backgroundcolor' => ['required', 'regex:/[0-255]{1,3},[0-255]{1,3},[0-255]{1,3},[0-1]{1,3}/'],
            'fillcolor' => ['required', 'regex:/[0-255]{1,3},[0-255]{1,3},[0-255]{1,3},[0-1]{1,3}/'],
            'size' => ['required', 'regex:/^\\d+$/'],
            'content' => ['required', 'regex:/[a-z]/'],
        ];
    }
}
