<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RuanganCreateRequest extends FormRequest
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
            'no_ruangan' => 'unique:ruangans|required',
            'kapasitas' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'no_ruangan' => 'No Ruangan Tidak Boleh Sama',
            'kapasitas' => 'Kapasitas Ruangan Wajib di Isi',
        ];
    }

    // public function attributes()
    // {
    //     return [

    //     ];
    // }
}
