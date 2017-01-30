<?php

namespace RadDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTubeRequest extends FormRequest
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
            'machine'       => 'required|integer',
            'hsgManufID'    => 'integer',
            'hsgModel'      => 'string|nullable|max:30',
            'hsgSN'         => 'string|nullable|max:20',
            'insertManufID' => 'integer',
            'insertModel'   => 'string|nullable|max:30',
            'insertSN'      => 'string|nullable|max:20',
            'manufDate'     => 'date_format:Y-m-d|max:10',
            'installDate'   => 'date_format:Y-m-d|max:10',
            'lfs'           => 'numeric',
            'mfs'           => 'numeric',
            'sfs'           => 'numeric',
            'notes'         => 'string|nullable|max:65535',
        ];
    }
}
