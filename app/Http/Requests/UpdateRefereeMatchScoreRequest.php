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
            'score_a' => ['required', 'integer', 'min:0'],
            'score_b' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:scheduled,in_progress,finished'],
        ];
    }
}