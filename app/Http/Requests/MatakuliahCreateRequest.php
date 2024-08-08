<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatakuliahCreateRequest extends FormRequest
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
            'kode_mk' => 'unique:matakuliahs|required',
            'nama' => 'required',
            'sks' => 'required',
            'semester' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'kode_mk' => 'Kode Matakuliah Tidak Boleh Sama',
            'nama' => 'Matakuliah Wajib di Isi',
            'sks' => 'SKS Wajib di Isi',
            'semester' => 'Semester Wajib di Isi',

        ];
    }

}
