<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClickRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['ip_address' => $this->ip()]);
    }

    public function rules(): array
    {
        return [
            'ip_address' => ['required'],
            'article_id' => ['required', 'exists:articles,id'],
            'user_agent' => ['nullable'],
        ];
    }
}
