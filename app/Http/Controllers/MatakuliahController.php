<?php

namespace App\Http\Controllers;
use App\Models\Matakuliah;
use Illuminate\Http\Request;


class MatakuliahController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getallmatakuliah()
    {
        $mk = Matakuliah::all();
        return \response()->json([
            "success" => true,
            "message" => "grabbed all mata kuliah",
            "matakuliah" => $mk
        ], 200);
    }
    

    public function creatematkul(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;
        $prodi = Matakuliah::create([
            'id'=> $id,
            'nama'=>$nama
        ]);
    }







    //
}
