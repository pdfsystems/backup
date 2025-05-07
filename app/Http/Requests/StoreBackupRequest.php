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
            'mime_type' => ['required'],
            'size' => ['required', 'integer'],
            'meta' => ['nullable', 'array'],
            'file' => ['required', 'file'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'meta' => ['foo' => 'bar'],
        ]);
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission(Backup::class, Action::Create);
    }
}
