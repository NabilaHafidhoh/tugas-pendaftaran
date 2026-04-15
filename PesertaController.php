<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;

class PesertaController extends Controller
{
    public function index()
    {
        $all = Peserta::orderBy('id','desc')->get();
        return view('peserta.index', [
            'all' => $all,
            'edit' => null
        ]);
    }

    public function store(Request $request)
    {
        // HANDLE FOTO
        $foto = null;
        if ($request->file('foto')) {
            $foto = time().'.'.$request->foto->extension();
            $request->foto->move(public_path('uploads'), $foto);
        }

        // HANDLE ARRAY
        $hobi = implode(', ', $request->hobi ?? []);
        $jk = implode(', ', $request->jk ?? []);

        if ($request->id == "") {
            Peserta::create([
                ...$request->all(),
                'hobi'=>$hobi,
                'jk'=>$jk,
                'foto'=>$foto
            ]);
        } else {
            $data = Peserta::find($request->id);

            if ($foto) {
                $data->foto = $foto;
            }

            $data->update([
                ...$request->all(),
                'hobi'=>$hobi,
                'jk'=>$jk
            ]);
        }

        return redirect('/peserta');
    }

    public function edit($id)
    {
        return view('peserta.index', [
            'all' => Peserta::all(),
            'edit' => Peserta::find($id)
        ]);
    }

    public function delete($id)
    {
        Peserta::find($id)->delete();
        return back();
    }

    public function getKota(Request $request)
    {
        $data = [];

        if($request->provinsi=="Jawa Timur"){
            $data = ["Surabaya","Malang","Sidoarjo"];
        } elseif($request->provinsi=="Jawa Tengah"){
            $data = ["Semarang","Solo","Magelang"];
        } elseif($request->provinsi=="Jawa Barat"){
            $data = ["Bandung","Bekasi","Bogor"];
        }

        $html = "<option value=''>Pilih Kota</option>";
        foreach($data as $d){
            $html .= "<option value='$d'>$d</option>";
        }

        return $html;
    }
}