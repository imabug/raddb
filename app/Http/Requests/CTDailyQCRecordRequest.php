<?php

namespace RadDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CTDailyQCRecordRequest extends FormRequest
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
            'qcdate'        => 'required|date_format:Y-m-d',
            'scan_type.*'     => 'required|string|in:Axial,Helical',
            'water_hu.*'      => 'required|numeric|min:-1200|max:1200',
            'water_sd.*'      => 'required|numeric|min:-1200|max:1200',
            'artifacts.*'     => 'string|in:Y,N',
            'initials'      => 'required|string|max:4',
            'notes'         => 'string|nullable|max:65535',
        ];
    }
}
