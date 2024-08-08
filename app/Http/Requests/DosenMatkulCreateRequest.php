<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenMatkulCreateRequest extends FormRequest
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
            'matakuliah_id' => 'required',
            'semester' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dosen_id' => 'Dosen Wajib di Isi',
            'matakuliah_id' => 'Matakuliah Wajib di Isi',
            'semester' => 'Semester Wajib di Isi',
        ];
    }
}
