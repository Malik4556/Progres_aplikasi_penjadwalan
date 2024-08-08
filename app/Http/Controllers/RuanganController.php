<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\RuanganCreateRequest;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        // dd($keyword);
        $ruangan = Ruangan::where('no_ruangan', 'LIKE', '%' . $keyword . '%')
                            ->orWhere('kapasitas', 'LIKE', '%' . $keyword . '%')
                            ->get();
        return view('ruangan.ruangan', ['ruanganList' => $ruangan]);
    }

    public function create()
    {
        $ruangan = Ruangan::select('id', 'no_ruangan', 'kapasitas')->get();
        return view('ruangan.ruangan-add', ['ruangan' => $ruangan]);
    }

    public function store(RuanganCreateRequest $request)
    {
        $ruangan=Ruangan::create($request->all());

        if($ruangan) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Ruangan Berhasil Ditambahkan');
        }
        return redirect('/ruangan');
    }

    public function edit(Request $request, $id)
    {
        $ruangan =  Ruangan::findOrFail($id);
        return view('ruangan.ruangan-edit', ['ruangan' => $ruangan]);
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->update($request->all());

        if($ruangan) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Ruangan Berhasil Dirubah');
        }

        return redirect('/ruangan');

    }

    public function delete($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('ruangan.ruangan-delete', ['ruangan' => $ruangan]);
    }

    public function destroy(Request $request, $id)
    {
        $deletedruangan = Ruangan::findOrFail($id);
        $deletedruangan->delete();
        if($deletedruangan) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Ruangan Berhasil Dihapus');
        }
        return redirect('/ruangan');

    }
}
