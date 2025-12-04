<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\FutureDate;
use App\Rules\TodayOnly;

class BorrowingRequest extends FormRequest
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
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'issue_date' => ['required', 'date', new TodayOnly],
            'due_date' => ['required', 'date', new FutureDate],
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'book_id.required' => 'The book selection is required.',
            'user_id.required' => 'The user selection is required.',
            'issue_date.required' => 'Issue date is required.',
            'due_date.required' => 'Due date is required.',
        ];
    }
}
