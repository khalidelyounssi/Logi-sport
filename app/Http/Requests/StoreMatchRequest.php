<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'organizer';
    }

    public function rules(): array
    {
        return [
            'participant_a_id' => ['required', 'exists:participants,id', 'different:participant_b_id'],
            'participant_b_id' => ['required', 'exists:participants,id'],
            'match_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:scheduled,in_progress,finished'],
            'referee_id' => ['nullable', 'exists:users,id'],
        ];
    }
}