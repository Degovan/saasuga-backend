<?php

namespace App\Http\Requests\Api;

use App\Exceptions\Api\FailedValidation;
use App\Traits\ApiResponser;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
{
    use ApiResponser;

    public $providers = [
        'google',
    ];

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [

        ];
    }

    public function validateProvider($provider)
    {
        if (! in_array($provider, $this->providers)) {
            throw new FailedValidation([
                'provider' => 'The provider is not valid',
            ]);
        }
    }

    protected function failedValidation(Validator $validator)
    {
        throw new FailedValidation($validator->errors());
    }
}
