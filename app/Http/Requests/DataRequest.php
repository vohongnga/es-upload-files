<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;
use App\Rules\ValidPassword;

class DataRequest extends FormRequest
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
            'first_name'    => 'required|alpha',
            // 'name' => 'regex:/^(?=.*[!@#$&*])(?=.*?[0-9]).{8,}$/',  //min:8, co it nhat mot ky tu dac biewt vaf 1 ky tu so
            // 'password'  =>'required|confirmed|regex:/^(?=.*[!@#$&*])(?=.*?[0-9]).{8,}$/',
            'phone'     => ['required','digits:10','regex:/^(032|033|034|035)[0-9]+$/'],
            'password'  =>['required', new ValidPassword(),'min:8' ],
            'name'  => ['required', new ValidPassword(),'min:8' ],
            'start_date'    =>'required|date|date_equals:today',
            'finish_date'   => 'required|date|after:start_date',
            'id'    => [new RequiredIf($this->status == 'on'), 'regex:/^\d{3}\\$/']

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