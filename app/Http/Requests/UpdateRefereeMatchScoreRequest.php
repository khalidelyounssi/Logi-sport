<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRefereeMatchScoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['referee', 'organizer']);
    }

    public function rules(): array
    {
        return [
            'score_a' => ['nullable', 'integer', 'min:0', 'required_if:status,finished'],
            'score_b' => ['nullable', 'integer', 'min:0', 'required_if:status,finished'],
            'status' => ['required', 'in:scheduled,in_progress,finished'],
        ];
    }
}
