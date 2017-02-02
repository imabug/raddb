<?php

namespace RadDB\Http\Requests;

use Illuminate\Http\Request;
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
    public function rules(Request $request)
    {
        // Build the validation rules
        $rules = array(
            'surveyId'       => 'required|exists:testdates,id|integer',
            'recommendation' => 'required|string|max:500',
            'resolved'       => 'integer',
            'WONum'          => 'string|nullable|max:20',
            'ServiceReport'  => 'file|mimes:pdf',
        );

        // If 'resolved' was checked, then add validation rules for
        // 'RecResolveDate' and 'ResolvedBy'.
        if ($request->has('resolved')) {
            $rules['RecResolveDate'] = 'required|date_format:Y-m-d';
            $rules['ResolvedBy'] = 'required|string|max:10';
        }
        return $rules;
    }
}
