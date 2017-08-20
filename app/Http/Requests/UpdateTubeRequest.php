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
            'machine_id'    => 'required|exists:machines,id|integer',
            'hsgManufID'    => 'integer|exists:manufacturers,id',
            'hsgModel'      => 'string|nullable|max:30',
            'hsgSN'         => 'string|nullable|max:20',
            'insertManufID' => 'integer|exists:manufacturers,id',
            'insertModel'   => 'string|nullable|max:30',
            'insertSN'      => 'string|nullable|max:20',
            'manufDate'     => 'date_format:Y-m-d|nullable',
            'installDate'   => 'date_format:Y-m-d|nullable',
            'lfs'           => 'numeric',
            'mfs'           => 'numeric',
            'sfs'           => 'numeric',
            'tube_status'   => 'required|in:Active,Removed|max:20',
            'notes'         => 'string|nullable|max:65535',
        ];
    }
}
