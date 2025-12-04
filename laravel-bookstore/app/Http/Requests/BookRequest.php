<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'book_category_id' => 'required|exists:book_cate,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The book title is required.',
            'author.required' => 'The author name is required.',
            'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'stock.required' => 'The stock quantity is required.',
            'stock.integer' => 'The stock must be a valid integer.',
            'book_category_id.required' => 'Please select a category.',
            'book_category_id.exists' => 'The selected category is invalid.',
        ];
    }
}
