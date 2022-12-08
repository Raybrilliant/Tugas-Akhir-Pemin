<?php

namespace App\Http\Controllers;
use App\Models\Prodi;
use Illuminate\Http\Request;


class ProdiController extends Controller
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
    public function getallprodi()
    {
        $prodi = Prodi::all();
        return response()->json([
            "success" => true,
            "message" => "Get all prodi",
            "prodi" => $prodi
        ], 200);
    }

    public function createprodi(Request $request)
    {
        $id = $request->id;
        $nama = $request->nama;
        $prodi = Prodi::create([
            'id'=> $id,
            'nama'=>$nama
        ]);
    }



    //
}
