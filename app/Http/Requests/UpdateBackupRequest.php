<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBackupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'meta' => ['nullable', 'array'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('backup'));
    }
}
