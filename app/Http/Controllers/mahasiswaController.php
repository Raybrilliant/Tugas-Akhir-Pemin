<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use Illuminate\Http\Request;





class mahasiswaController extends Controller
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

    public function getallmahasiswa()
    {
        $Mahasiswa = Mahasiswa::with("prodi")->get();
        // return $Mahasiswa;
        return response()->json([
            'success' => true,
            'message' => 'grabbed all mahasiswa',
            'mahasiswa'=> $Mahasiswa
            
            ],200);
    }

    public function getMahasiswaByNIM(Request $request)
    {
        $mahasiswa = Mahasiswa::with('prodi', 'matakuliah')->find($request->nim);
        return response()->json([
            'success' => true,
            'message' => 'All post grabbed',
            'mahasiswa' => $mahasiswa
        ], 200);
    }

    public function tambahMatakuliah(Request $request, $nim, $mkId)
    {
        $mhs = Mahasiswa::findOrFail($nim);
        $mk = Matakuliah::findOrFail($mkId);

        if ($request->mahasiswa->nim !== $mhs->nim) {
            return \response()->json([
                "success" => false,
                "message" => "Matakuliah added to mahasiswa"
            ]);
        }

        $mhs->matakuliah()->attach($mk->id);

        return \response()->json([
            "success" => true,
            "message" => "Matakuliah added to mahasiswa"
        ]);
    }

    public function deleteMatakuliah(Request $request, $nim, $mkId)
    {
        $mhs = Mahasiswa::findOrFail($nim);

        $mk = Matakuliah::findOrFail($mkId);
        if ($request->mahasiswa->nim !== $nim) {
            return \response()->json([
                "success" => false,
                "message" => "gagal"
            ]);
        }

        $mhs->matakuliah()->detach($mk->id);

        return \response()->json([
            "success" => true,
            "message" => "Matakuliah deleted to mahasiswa"
        ]);
    }

    public function getProfile(Request $request)
    {
        $mahasiswa = $request->mahasiswa;

         return response()->json([
            'success' => true,
            'message' => 'grabbed mahasiswa by token',
            'mahasiswa' =>  $mahasiswa->makeHidden("token") 
        ], 200);
    }





    //
}
