<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\DosenCreateRequest;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        // dd($keyword);
        $dosen = Dosen::where('kode_dos', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('nama', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('email', 'LIKE', '%' . $keyword . '%')
                            ->orderBy('nama', 'asc')  // Urutkan berdasarkan nama
                            ->get();
        return view('dosen.dosen', ['dosenList' => $dosen]);
    }

    public function create()
    {
        $dosen = Dosen::select('id', 'kode_dos', 'nama', 'email')->get();
        return view('dosen.dosen-add', ['dosen' => $dosen]);
    }

    public function store(DosenCreateRequest $request)
    {
        $dosen=Dosen::create($request->all());

        if($dosen) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen Berhasil Ditambahkan');
        }
        return redirect('/dosen');
    }

    public function edit(Request $request, $id)
    {
        $dosen =  Dosen::findOrFail($id);
        return view('dosen.dosen-edit', ['dosen' => $dosen]);
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);
        $dosen->update($request->all());

        if($dosen) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Dosen Berhasil Dirubah');
        }

        return redirect('/dosen');
    }

    public function delete($id)
    {
        $dosen = Dosen::findOrFail($id);
        return view('dosen.dosen-delete', ['dosen' => $dosen]);
    }

    public function destroy(Request $request, $id)
    {
        $deleteddosen = Dosen::findOrFail($id);
        $deleteddosen->delete();
        if($deleteddosen) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Ruangan Berhasil Dihapus');
        }
        return redirect('/dosen');

    }
}
