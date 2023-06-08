<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreProductsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:10|regex:/^[\s\w-]*$/',
            'code' => 'required|string|max:10|regex:/^[a-z0-9_-]*$/',
            'category' => 'required|string',
            'price' => 'required|numeric|between:0,9999999999.99',
            'tags' => 'required|array',
            'release_date' => 'required|date'
        ];
    }
}
