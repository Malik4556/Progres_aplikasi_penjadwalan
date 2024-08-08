<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JamCreateRequest extends FormRequest
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
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'jam_mulai.required' => 'Jam Mulai wajib diisi',
            'jam_mulai.date_format' => 'Format Jam Mulai tidak valid',
            'jam_selesai.required' => 'Jam Selesai wajib diisi',
            'jam_selesai.date_format' => 'Format Jam Selesai tidak valid',
        ];
    }
}
