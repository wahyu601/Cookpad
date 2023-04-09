<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User; //panggil model user
use App\Models\Log; //panggil model Log
use Firebase\JWT\JWT; //panggil library jwt
use Illuminate\Support\Facades\Validator; //panggil library validator untuk validasi inputan
use Illuminate\Support\Facades\Auth; //panggil library untuk otentikasi
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    //fungsi atau fitur registrasi akun
    public function register(Request $request) {

        // buat validasi inputan
        $validator = Validator::make($request->all(),[
            'nama' => 'required', //nama harus diisi
            'email' => 'required|unique:user,email', //email harus diisi, berformat email, dan unik
            'password' => 'required|min:8',//password harus diisi, minimal 8 karakter
            'confirmation_password' => 'required|same:password' //konfirmasi password harus diisi, dan sesuai dengan password
        ]);

        // kondisi ketika satu atau lebih inputan tidak sesuai aturan diatas
        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        $user = $validator->validated();

        // masukkan ke database tabel user
        User::create($user);

        // isi token JWT
        $payload = [
            'nama' => $user['nama'],
            'role' => 'user',
            'iat' => now()->timestamp, //waktu dibuat token
            'exp' => now()->timestamp + 7200 //waktu kadaluarsa token (2 jam setelah token dibuat)
        ];

        // generate token dengan algoritma HS256
        $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');

        // buat log login
        Log::create([
            'module' => 'login',
            'action' => 'login akun',
            'useraccess' => $user['email']
        ]);

        // kirim response ke pengguna
        return response()->json([
            "data" => [
                'msg' => "berhasil login",
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => 'user',
            ],
            "token" => "Bearer {$token}"
        ],200);

        // kondisi ketika satu atau lebih inputan tidak sesuai diatas
        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        if(Auth::attempt($validator->validated())) {

            $payload = [
                'nama' => Auth::user()->nama,
                'role' => Auth::user()->role,
                'iat' => now()->timestamp,
                'exp' => now()->timestamp + 7200
            ];

            $token = JWT::encode($payload,env('JWT_SECRET_KEY'),'HS256');

            Log::create([
                'module' => 'login',
                'action' => 'login akun',
                'useraccess' => Auth::user()->email
            ]);

            return response()->json([
                "data" => [
                    'msg' => "berhasil login",
                    'nama' => Auth::user()->nama,
                    'email' => Auth::user()->email,
                    'role' => Auth::user()->role,
                ],
                "token" => "Bearer {$token}"
            ],200);
        }

        return response()->json("email atau password salah",422);
    }
}
