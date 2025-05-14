<?php

namespace App\Http\Requests;

use App\Enums\Action;
use App\Models\Backup;
use Illuminate\Foundation\Http\FormRequest;

class DownloadBackupsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'application_id' => ['required', 'exists:applications,id'],
            'type' => ['required', 'string'],
            'filename_meta_key' => ['string'],
            'start_date' => ['date'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission(Backup::class, Action::Read);
    }

    public function getMetaFilters(): array
    {
        $meta = [];

        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, 'meta_') && ! empty($value)) {
                $meta[substr($key, 5)] = $value;
            }
        }

        return $meta;
    }
}
