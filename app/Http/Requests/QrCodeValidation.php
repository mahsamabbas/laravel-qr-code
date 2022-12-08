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
            'backgroundcolor' => ['required', 'regex:/(\d{1,3}),(\d{1,3}),(\d{1,3}),(\d{1,1})/'],
            'fillcolor' => ['required', 'regex:/(\d{1,3}),(\d{1,3}),(\d{1,3}),(\d{1,1})/'],
            'size' => ['required', 'regex:/^\d+$/'],
            'content' => ['required', 'regex:/^[A-Za-z ]+$/'],
        ];
    }
}
