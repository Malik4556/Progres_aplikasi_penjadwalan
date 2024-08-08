<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaCreateRequest extends FormRequest
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
            'angkatan' => 'required',
            'semester' => 'required',
            'jml_mahasiswa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'angkatan' => 'Angkatan Mahassiwa Wajib di Isi',
            'semester' => 'Angkatan Mahassiwa Wajib di Isi',
            'jml_mahasiswa' => 'Angkatan Mahassiwa Wajib di Isi',
        ];
    }

    // public function rules()
    // {
    //     return [
    //         //
    //     ];
    // }
}
