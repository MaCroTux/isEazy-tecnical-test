<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class UpdateShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id' => 'required|numeric|exists:shops,id',
            'name' => 'required|string|max:255',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = new JsonResponse([
            'status' => key($validator->failed()) === 'id'
                ? 'not_found'
                : 'error',
            'msg' => 'Error wrong parameters',
        ], key($validator->failed()) === 'id'
            ? 404
            : 402
        );

        throw new ValidationException($validator, $response);
    }
}
