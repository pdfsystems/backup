<?php

namespace App\Http\Requests;

use App\Enums\Action;
use App\Models\Backup;
use Illuminate\Foundation\Http\FormRequest;

class ListBackupsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'application_id' => ['exists:applications,id'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission(Backup::class, Action::Read);
    }
}
