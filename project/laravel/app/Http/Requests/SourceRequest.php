<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SourceRequest extends FormRequest
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
            'name' => [
                'required',
                $this->method() == 'PUT'
                    ? Rule::unique('sources')->ignore($this->id)
                    : Rule::unique('sources'),
            ],
            'domain' => ['required'],
            'type' => ['required'],
            'status' => ['required'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Please enter name',
            'domain.required' => 'Please enter domain',
            'type.required' => 'Please enter first name',
            'status.required' => 'Please enter first name',
        ];
    }
}
