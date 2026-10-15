<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class CorporateMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'corporate_name' => 'required|string|max:255',
            'corporate_contact' => 'required|string|max:255',
            'hari_acara' => 'required|integer',
            'jumlah_peserta' => 'required|integer',
            'add_hotel' => 'required|boolean',
            'lokasi_start' => 'required|string|max:255',
        ];
    }
}
