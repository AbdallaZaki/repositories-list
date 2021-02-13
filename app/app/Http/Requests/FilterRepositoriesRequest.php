<?php

namespace App\Http\Requests;

use App\Services\GithuhServices\Helpers\Sorter;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class FilterRepositoriesRequest extends FormRequest
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
            'filter_by' => ['nullable','array'],
            'sort_by' => ['nullable','string',Rule::in(array_keys((new Sorter())->defaultSorters))],
            'sort_direction' => ['nullable','string',Rule::in((new Sorter())->allowedDirections)],
            'per_page' => ['nullable','integer', Rule::in([10,30,100])]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse(['data' => [],
            'meta' => [
                'message' => 'The given data is invalid',
                'errors' => $validator->errors()
            ]], 422);

        throw new ValidationException($validator, $response);
    }
}
