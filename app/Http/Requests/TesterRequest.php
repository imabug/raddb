<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TesterRequest extends FormRequest
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
     * @return array<string, string>
     */
    public function rules()
    {
        return [
            'name'     => 'required|string|max:25',
            'initials' => 'required|string|max:3',
        ];
    }
}
