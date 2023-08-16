<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OpNoteStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'machineId' => 'required|exists:machines,id|integer',
            'note'      => 'required|string|max:1024',
        ];
    }
}
