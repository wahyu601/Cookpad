<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdminController extends Controller
{
    public function register(Request $request) {

        $validator = Validator::make($request->all(),[
            'nama' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8',
            'confirmation_password' => 'required|same:password',
            'role' => 'required|in:admin,user',
            'status' => 'required|in:aktif,non-aktif',
            'email_validate' => 'required|email'
        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        $user = $validator->validated();

        User::create($user);

        return response()->json([
            "data" => [
                'msg' => 'berhasil login',
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]
        ],200);
    }

    public function show_register(){

        // munculkan semua akun dengan role user
        $users = User::where('role','user')->get();

        return response()->json([
            "data" => [
                'msg' => "user registrasi",
                'data' => $users
            ]
        ],200);
    }

    public function show_register_by_id($id){

        // munculkan akun berdasarkan id
        $user = User::find($id);

        return response()->json([
            "data" => [
                'msg' => "user id: {$id}",
                'data' => $user
            ]
        ],200);
    }

    public function update_register(Request $request,$id) {
        $user = User::find($id);

        if($user) {

            $validator = Validator::make($request->all(),[
                'nama' => 'required',
                'password' => 'min:8',
                'confirmation_password' => 'same:password',
                'role' => 'required|in:admin,user',
                'status' => 'required|in:aktif,non-aktif',
                'email_validate' => 'required|email'
            ]);
    
            if($validator->fails()) {
                return messageError($validator->messages()->toArray());
            }

            $data = $validator->validated();

            User::where('id',$id)->update($data);

            return response()->json([
                'data' => [
                    "msg" => "user dengan id: {$id} berhasil diupdate",
                    'nama' => $data['nama'],
                    'email' => $user['email'],
                    'role' => $data['role'],
                ]
            ],200);
        }

        return response()->json([
            "data" => [
                'msg' => "user id: {$id}, tidak ditemukan"
            ]
        ],422);
    }


    public function delete_register($id) {

        $user = User::find($id);

        if($user) {

            $user->delete();

            return response()->json([
                "data" => [
                    'msg' => "user dengan id {$id}, berhasil dihapus"
                ]
            ],200);
        }

        return response()->json([
            "data" => [
                'msg' => "user dengan id {$id}, tidak ditemukan"
            ]
        ],422);
    }

    public function activation_account($id) {
        $user = User::find($id);

        if($user) {

            User::where('id',$id)->update(['status' => 'aktif']);

            return response()->json([
                "data" => [
                    'msg' => "user dengan id {$id} berhasil diaktifkan"
                ]
            ],200);
        }

        return response()->json([
            "data" => [
                'msg' => "user dengan id {$id}, tidak ditemukan"
            ]
        ],422);
    }

    public function deactivation_account($id) {
        $user = User::find($id);

        if($user) {

            User::where('id',$id)->update(['status' => 'non-aktif']);

            return response()->json([
                "data" => [
                    'msg' => "user dengan id {$id} berhasil dinonaktifkan"
                ]
            ],200);
        }

        return response()->json([
            "data" => [
                'msg' => "user dengan id {$id}, tidak ditemukan"
            ]
        ],422);
    }
}
