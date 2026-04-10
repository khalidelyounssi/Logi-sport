<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRefereeMatchScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'referee';
    }

    public function rules(): array
    {
        return [
            'score_a' => ['nullable', 'integer', 'min:0'],
            'score_b' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:scheduled,in_progress,finished'],
            'expected_updated_at' => ['nullable', 'date'],
        ];
    }
}