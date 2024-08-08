<?php

namespace App\Http\Controllers;

use App\Models\Hari;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\HariCreateRequest;

class HariController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $hari = Hari::where('id', 'LIKE', '%' . $keyword . '%')
            ->orWhere('hari', 'LIKE', '%' . $keyword . '%')
            ->paginate(5);

        return view('hari.hari', ['hariList' => $hari]);
    }

    public function create()
    {
        $hari = Hari::select('id', 'hari')->get();
        return view('hari.hari-add', ['hari' => $hari]);
    }

    public function store(HariCreateRequest $request)
    {
        $hari = Hari::create($request->all());

        if ($hari) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Hari Berhasil Ditambahkan');
        }
        return redirect('/hari');
    }

    public function edit(Request $request, $id)
    {
        $hari =  Hari::findOrFail($id);

        return view('hari.hari-edit', ['hari' => $hari]);
    }

    public function update(Request $request, $id)
    {
        $hari = Hari::findOrFail($id);
        $hari->update($request->all());

        if($hari) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Hari Berhasil Dirubah');
        }

        return redirect('/hari');
    }

    public function delete($id)
    {
        $hari = Hari::findOrFail($id);
        return view('hari.hari-delete', ['hari' => $hari]);
    }

    public function destroy(Request $request, $id)
        {
        $deletedhari = Hari::findOrFail($id);
        $deletedhari->delete();

        if($deletedhari) {
            Session::flash('status', 'success');
            Session::flash('message', 'Data Hari Berhasil Dihapus');
        }

        return redirect('/hari');
    }

}
