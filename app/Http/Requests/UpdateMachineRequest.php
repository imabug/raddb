<?php

namespace RadDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMachineRequest extends FormRequest
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
            'modality'     => 'required|integer',
            'description'  => 'required|string|max:60',
            'manufacturer' => 'required|integer',
            'model'        => 'required|string|max:20',
            'serialNumber' => 'required|string|max:20',
            'vendSiteID'   => 'string|nullable|max:25',
            'manufDate'    => 'date_format:Y-m-d|max:10',
            'installDate'  => 'date_format:Y-m-d|max:10',
            'location'     => 'required|integer',
            'room'         => 'required|string|max:20',
            'status'       => 'required|in:Active,Inactive,Removed|max:50',
            'notes'        => 'string|nullable|max:65535',
        ];
    }
}
