<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'file' =>'required|mimes:png,jpg,txt, docx, csv, pdf',
            'files' =>'required',
            'files.*'   => 'bail|required',

        ];
    }

    /**
     * Get the message when error validate
     *
     * @return array
     */
    public function messages()
    {
        return [
        ];
    }
}