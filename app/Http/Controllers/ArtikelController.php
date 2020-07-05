<?php

namespace App\Http\Controllers;

use App\Models\ArtikelModel as ModelsArtikelModel;
use Illuminate\Http\Request;
use App\Models\ArtikelModel;

class ArtikelController extends Controller
{

    public function index()
    {
        $data = ArtikelModel::get_all();
        return view('pages.index', compact('data'));
    }
    public function show($id)
    {
        $data = ArtikelModel::get($id);
        // var_dump($data);
        return view('pages.show', compact('data'));
    }
    public function destroy($id)
    {
        ArtikelModel::delete($id);
        return redirect('/artikel');
    }
    public function edit($id)
    {
        $data = ArtikelModel::get($id);
        return view('pages.edit_artikel', compact('data'));
    }
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'judul' => ['required', 'max:255'],
            'isi' => ['required', 'max:255'],
            'tag' => ['required', 'max:255'],
        ]);
        $take = strtolower($data['judul']);
        $split = explode(" ", $take);
        $slug = $split[0];
        if (count($split) > 1) {
            for ($i = 1; $i < count($split); $i++) {
                $slug .= "-" . $split[$i];
            }
        }
        // echo $slug;
        $data['slug'] = $slug;
        // var_dump($data);
        // }
        // var_dump($data);
        $data = ArtikelModel::edit($data, $id);
        return redirect('/artikel');
    }
    public function create()
    {
        return view('pages/create_artikel');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'max:255'],
            'isi' => ['required', 'max:255'],
        ]);
        $data = $request->all();
        unset($data["_token"]);
        $take = strtolower($data['judul']);
        $split = explode(" ", $take);
        $slug = $split[0];
        if (count($split) > 1) {
            for ($i = 1; $i < count($split); $i++) {
                $slug .= "-" . $split[$i];
            }
        }
        // echo $slug;
        $data['slug'] = $slug;
        // var_dump($data);
        // }
        $item = ArtikelModel::store($data);
        if ($item) {
            return redirect('/artikel');
        }
    }
}