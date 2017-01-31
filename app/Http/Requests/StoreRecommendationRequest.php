<?php

namespace RadDB\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecommendationRequest extends FormRequest
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
            'surveyId'       => 'required|exists:testdates,id|integer',
            'recommendation' => 'required|string|max:500',
            'resolved'       => 'integer',
            'WONum'          => 'string|nullable|max:20',
            'RecResolveDate' => 'required_with:resolved|date_format:Y-m-d',
            'ResolvedBy'     => 'required_with:resolved|string|max:10',
            'ServiceReport'  => 'file|mimes:pdf',
        ];
    }
}
