<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    
    public function authorize(): bool
{
    return auth()->user()->role === 'organizer';
}

public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255'],
        'type' => ['required', 'in:team,player'],
    ];
}
}
