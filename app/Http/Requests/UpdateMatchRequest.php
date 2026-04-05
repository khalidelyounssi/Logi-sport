<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['organizer', 'referee'], true);
    }

    public function rules(): array
    {
        return [
            'participant_a_id' => ['required', 'exists:participants,id', 'different:participant_b_id'],
            'participant_b_id' => ['required', 'exists:participants,id'],
            'match_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:scheduled,in_progress,finished'],
            'referee_id' => [
                'nullable',
                Rule::exists('users', 'id')
                    ->where('role', 'referee')
                    ->where('is_active', true),
            ],
            'score_a' => ['nullable', 'integer', 'min:0', 'required_if:status,finished'],
            'score_b' => ['nullable', 'integer', 'min:0', 'required_if:status,finished'],
        ];
    }
}
