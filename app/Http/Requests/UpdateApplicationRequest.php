<?php

namespace App\Http\Requests;

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
        return $this->user()->can('update', $this->route('application'));
    }
}
