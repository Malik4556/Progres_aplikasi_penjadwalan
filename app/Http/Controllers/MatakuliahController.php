<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\MatakuliahCreateRequest;

class MatakuliahController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $matakuliah = Matakuliah::where('kode_mk', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('nama', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('sks', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('semester', 'LIKE', '%' . $keyword . '%')
                            ->orderBy('semester', 'asc')  // Urutkan berdasarkan semester
                            ->orderBy('nama', 'asc')  // Urutkan berdasarkan nama
                            ->get();
                            // ->paginate(6);

        return view('matakuliah.matakuliah', ['matakuliahList' => $matakuliah]);
    }

    public function create()
    {
        $matakuliah = Matakuliah::select('id', 'kode_mk', 'nama', 'sks', 'semester')->get();
        return view('matakuliah.matakuliah-add', ['matakuliah' => $matakuliah]);
    }

    public function store(MatakuliahCreateRequest $request)
    {

        $matakuliah=Matakuliah::create($request->all());

        if($matakuliah) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Matakuliah Berhasil Ditambahkan');
        }
        return redirect('/matakuliah');
    }

    public function edit(Request $request, $id)
    {
        $matakuliah =  Matakuliah::findOrFail($id);
        return view('matakuliah.matakuliah-edit', ['matakuliah' => $matakuliah]);
    }

    public function update(Request $request, $id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        $matakuliah->update($request->all());

        if($matakuliah) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Matakuliah Berhasil Dirubah');
        }

        return redirect('/matakuliah');
    }

    public function delete($id)
    {
        $matakuliah = Matakuliah::findOrFail($id);
        return view('matakuliah.matakuliah-delete', ['matakuliah' => $matakuliah]);
    }

    public function destroy(Request $request, $id)
    {
        $deletedmatakuliah = Matakuliah::findOrFail($id);
        $deletedmatakuliah->delete();
        if($deletedmatakuliah) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Matakuliah Berhasil Dihapus');
        }
        return redirect('/matakuliah');

    }
}
