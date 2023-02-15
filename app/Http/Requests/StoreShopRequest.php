<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class StoreShopRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:shops,name|string|max:255',
            'products.*.name' => 'required|unique:products,name|string|max:255',
            'products.*.stock' => 'required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = new JsonResponse([
            'status' => 'error',
            'msg' => 'Error wrong parameters',
        ], 402);

        throw new ValidationException($validator, $response);
    }
}
