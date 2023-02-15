<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ShoppingRequest extends FormRequest
{
    private array $responseStatus = [
        'shop_id' => [
            'status' => 'shop_not_exist',
            'message' => 'Id shop not exist.',
            'code' => 404,
        ],
        'product_id' => [
            'status' => 'product_not_exist',
            'message' => 'Id product not exit.',
            'code' => 404
        ],
        'units' => [
            'status' => 'wrong_parameter_unit',
            'message' => 'Parameter unit is incorrect.',
            'code' => 402
        ]
    ];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shop_id' => 'required|numeric|exists:shops,id',
            'product_id' => 'required|numeric|exists:products,id',
            'units' => 'required|numeric|max:1000',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        $response = new JsonResponse([
            'status' => $this->responseStatus[key($validator->failed())]['status'],
            'msg' => $this->responseStatus[key($validator->failed())]['message'],
        ], $this->responseStatus[key($validator->failed())]['code']);

        throw new ValidationException($validator, $response);
    }
}
