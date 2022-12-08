<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Str;
use Firebase\JWT\JWT;

class authController extends Controller
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
    public function register(Request $request)
    {
        $nim = $request->nim;
        $nama = $request->nama;
        $angkatan = $request->angkatan;
        $password = Hash::make($request->password);
        $prodiId = $request->prodiId;
        if(!$prodiId){
            $Mahasiswa = Mahasiswa::create([
                'nim' => $nim,
                'nama' => $nama,
                'angkatan' => $angkatan,
                'password' => $password
                ]);
        
        }
        else{
            $Mahasiswa = Mahasiswa::create([
                'nim' => $nim,
                'nama' => $nama,
                'angkatan' => $angkatan,
                'password' => $password,
                'prodiId' =>$prodiId
                ]);
                
        }
        return response()->json([
            'success' => true,
            'message' => 'Successfully registered'
            ],200);
        
    }

    public function login(Request $request)
    {
        $nim = $request->nim;
        $password = $request->password;

        $Mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$Mahasiswa) {
        return response()->json([
            'status' => 'Error',
            'message' => 'user not exist',
        ], 404);
        }

        if (!Hash::check($password, $Mahasiswa->password)) {
        return response()->json([
            'status' => 'Error',
            'message' => 'wrong password',
        ], 400);
        }

        $Mahasiswa->token = $this->jwt($Mahasiswa); //
        $Mahasiswa->save();

        return response()->json([
        'success' => true,
        'message' => 'Successfully logged in',
        'token'=> $Mahasiswa->token
        ], 200);
    }
    protected function jwt(Mahasiswa $Mahasiswa)
    {
    $payload = [
        'iss' => 'lumen-jwt', //issuer of the token
        'sub' => $Mahasiswa->nim, //subject of the token
        'iat' => time(), //time when JWT was issued.
        'exp' => time() + 60 * 60 //time when JWT will expire
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    
    //
}
