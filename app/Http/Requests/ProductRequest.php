<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image_urls' => 'nullable|array',
            'image_urls.*' => 'url',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH'))
            {
                $rules['slug'] = [
                    'nullable',
                    'string',
                    Rule::unique('products')->ignore($this->product),
                ];
            } else {
                $rules['slug'] = 'nullable|string|unique:products';
            }

        return $rules;

    }
}
