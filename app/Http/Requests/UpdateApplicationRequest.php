<?php

namespace App\Http\Requests;

use App\Enums\Action;
use App\Models\Application;
use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'url' => ['nullable'],
        ];
    }

    public function authorize(): bool
    {
        return $this->user()->hasPermission(Application::class, Action::Update);
    }
}
