<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class FieldRequest extends FormRequest
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
                $this->method() == 'POST'
                    ? Rule::unique('enquiry_fields')->where(function ($query) {
                        return $query->where('company_id', $this->user()->company->id);
                    })
                    : Rule::unique('enquiry_fields')->where(function ($query) {
                        return $query->where('company_id', $this->user()->company->id);
                    })->ignore($this->id),
                ],
            'label' => ['required'],
            'type' => ['required'],
            'field_data' => [$this->type > 1 ? 'required' : ''],
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
            'name.unique' => 'Field Name Already Exists',
            'label.required' => 'Field Label is Required',
            'type.required' => 'Field Type is Required',
            'field_data.required' => 'Field Data is Required',
        ];
    }
}
