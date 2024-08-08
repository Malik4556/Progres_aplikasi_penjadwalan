<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenWaktuCreateRequest extends FormRequest
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
            'dosen_id' => 'required',
            'hari_id' => 'required',
            'jam_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dosen_id' => 'Dosen Wajib di Isi',
            'hari_id' => 'Hari Wajib di Isi',
            'jam_id' => 'Jam Wajib di Isi',
        ];
    }
}
