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
            'filename' => ['required'],
            'type' => ['nullable', 'string'],
            'meta' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission(Backup::class, Action::Update);
    }
}
