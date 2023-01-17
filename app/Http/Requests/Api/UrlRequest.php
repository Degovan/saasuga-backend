<?php

namespace App\Http\Requests\Api;

use App\Exceptions\Api\FailedValidation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UrlRequest extends FormRequest
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

    public function rules()
    {
        return [
            'destination' => 'required|url',
            'title' => 'nullable|string',
            'keyword' => [
                'required',
                'alpha_dash',
                Rule::unique('urls', 'keyword')
                    ->ignore($this->keyword, 'keyword'),
            ],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidation($validator->errors());
    }
}
