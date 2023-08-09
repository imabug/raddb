<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecommendationRequest extends FormRequest
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
            'recID'          => 'array',
            'WONum'          => 'string|nullable|max:20',
            'RecResolveDate' => 'required|date_format:Y-m-d',
            'ResolvedBy'     => 'string|max:10',
            'ServiceReport'  => 'file|mimes:pdf',
        ];
    }
}
