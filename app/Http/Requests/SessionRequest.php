<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge(['ip' => $this->ip()]);
    }

    public function rules(): array
    {
        return [
            'ip'         => ['required', 'string'],
            'article_id' => ['required', 'exists:articles,id'],
            'user_agent' => ['nullable'],
            'duration'   => ['required', 'numeric']
        ];
    }
}
