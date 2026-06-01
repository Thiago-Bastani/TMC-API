<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'receiver_id' => ['required', 'integer', 'exists:users,id'],
            'content'     => ['nullable', 'string', 'max:5000'],
            'file'        => ['nullable', 'file', 'mimes:jpeg,jpg,png,gif,mp3,ogg,webm,m4a', 'max:51200'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            if (empty($this->content) && !$this->hasFile('file')) {
                $validator->errors()->add('content', 'A message must have text or an attached file.');
            }
        });
    }
}
