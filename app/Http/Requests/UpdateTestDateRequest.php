<?php

namespace RadDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestDateRequest extends FormRequest
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
            'machineID' => 'required|integer',
            'test_date' => 'required|date_format:Y-m-d|max:10',
            'tester1ID' => 'required|string|max:4',
            'tester2ID' => 'string|max:4',
            'test_type' => 'required|integer',
            'notes'     => 'string|max:65535',
            'accession' => 'string|max:50',
        ];
    }
}
