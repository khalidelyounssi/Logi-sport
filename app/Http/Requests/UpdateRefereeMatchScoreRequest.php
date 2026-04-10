<?php

namespace App\Http\Requests;

use App\Models\MatchModel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

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

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            /** @var MatchModel|null $match */
            $match = $this->route('match');

            if (! $match) {
                return;
            }

            $match->loadMissing('tournament');

            if (
                $match->tournament &&
                $match->tournament->type === 'elimination' &&
                $this->status === 'finished' &&
                $this->score_a !== null &&
                $this->score_b !== null &&
                (int) $this->score_a === (int) $this->score_b
            ) {
                $validator->errors()->add(
                    'score_a',
                    'Elimination matches cannot end in a draw. Please enter a winning score.'
                );
            }
        });
    }
}