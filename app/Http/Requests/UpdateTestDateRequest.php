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
            'machineID' => 'required|exists:machines,id|integer',
            'test_date' => 'required|date_format:Y-m-d',
            'tester1ID' => 'required|exists:testers,id|integer',
            'tester2ID' => 'integer|exists:testers,id',
            'test_type' => 'required|exists:testtypes,id|integer',
            'notes'     => 'string|nullable|max:65535',
            'accession' => 'string|nullable|max:50',
        ];
    }
}
