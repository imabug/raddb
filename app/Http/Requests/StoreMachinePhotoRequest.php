<?php

namespace RadDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMachinePhotoRequest extends FormRequest
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
            'machineId'     => 'required|exists:machines,id|integer',
            'photo' => 'required|file|mimes:jpeg,png,gif',
            'photoDescription' => 'string',
        ];
    }
}
