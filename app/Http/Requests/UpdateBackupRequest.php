<?php

namespace App\Http\Requests;

use App\Enums\Action;
use App\Models\Backup;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBackupRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'application_id' => ['required', 'exists:applications'],
            'disk' => ['required'],
            'filename' => ['required'],
            'mime_type' => ['required'],
            'size' => ['required', 'integer'],
            'meta' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission(Backup::class, Action::Update);
    }
}
