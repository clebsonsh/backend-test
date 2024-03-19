<?php

namespace App\Http\Requests;

use App\Rules\ValidUrl;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRedirectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'url' => ['required', 'string', 'max:255', new ValidUrl()],
            'status' => ['nullable', 'string', 'in:active,inactive'],
        ];
    }
}