<?php

namespace App\Http\Requests;

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
            'modality'        => 'required|exists:modalities,id|integer',
            'description'     => 'required|string|max:60',
            'manufacturer'    => 'required|exists:manufacturers,id|integer',
            'model'           => 'required|string|max:50',
            'serialNumber'    => 'required|string|max:20',
            'softwareVersion' => 'string|max:50|nullable',
            'vendSiteID'      => 'string|nullable|max:25',
            'manufDate'       => 'date_format:Y-m-d|nullable',
            'installDate'     => 'date_format:Y-m-d|nullable',
            'location'        => 'required|integer',
            'room'            => 'required|string|max:20',
            'status'          => 'required|in:Active,Inactive,Removed|max:50',
            'notes'           => 'string|nullable|max:65535',
        ];
    }
}
