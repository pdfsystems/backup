<?php

namespace App\Http\Requests;

use App\Enums\Action;
use App\Models\Backup;
use Illuminate\Foundation\Http\FormRequest;

class StoreBackupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'application_id' => ['required', 'exists:applications,id'],
            'disk' => ['nullable'],
            'filename' => ['required'],
            'type' => ['nullable', 'string'],
            'mime_type' => ['required'],
            'size' => ['required', 'integer'],
            'meta' => ['nullable', 'array'],
            'file' => ['required', 'file'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('meta')) {
            $this->merge([
                'meta' => json_decode($this->get('meta'), true),
            ]);
        }
    }

    public function authorize(): bool
    {
        return $this->user()->can('create', Backup::class);
    }
}
