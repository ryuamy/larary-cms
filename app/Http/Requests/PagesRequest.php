<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PagesRequest extends FormRequest
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
            'title' => 'required|alpha_num_spaces',
            // 'permalink' => 'required|slug',
            'content' => 'required',
            'status' => 'required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'Title can not be empty.',
            'title.alpha_num_spaces' => 'Title only allowed alphanumeric with spaces.',
            // 'permalink.required' => 'Permalink can not be empty.',
            // 'permalink.slug' => 'Permalink only allowed letters and numbers  with dash or underscore.',
            'content.required' => 'Content can not be empty.',
            'status.required' => 'Status must be selected.',
        ];
    }
}
