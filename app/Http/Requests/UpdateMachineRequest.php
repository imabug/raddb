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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'modality_id'     => 'required|integer',
            'description'     => 'required|string|max:60',
            'manufacturer_id' => 'required|integer',
            'model'           => 'required|string|max:20',
            'serialNumber'    => 'required|string|max:20',
            'vendSiteID'      => 'string|max:25',
            'manufDate'       => 'date_format:Y-m-d|max:10',
            'installDate'     => 'date_format:Y-m-d|max:10',
            'location_id'     => 'required|integer',
            'room'            => 'required|string|max:20',
            'status'          => 'required|in:Active,Inactive,Removed|max:50',
            'notes'           => 'string|max:65535',
        ];
    }
}
