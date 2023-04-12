<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Recipe; //panggil model recipe
use App\Models\Tool; //panggil model tool
use App\Models\Ingredients; // panggil ingredients
use App\Models\RecipeView; // panggil model RecipeView
use Illuminate\Support\Facades\DB; // panggil query builder

class RecipeController extends Controller
{
    public function show_recipes(){
        // panggil resep yang berstatus publish dan relasinya dengan table user
        $recipes = Recipe::with('user')->where('status_resep','publish')->get();

        $data = [];
        foreach($recipes as $recipe) {

            array_push($data,[
                'idresep' => $recipe->idresep,
                'judul' => $recipe->judul,
                'gambar' => url($recipe->gambar),
                'nama' => $recipe->user->nama,
            ]);
        }

        return response()->json($data,200);
    }

    public function recipe_by_id(Request $request) {
        $validator = Validator::make($request->all(),[
            'idresep' => 'required',
            'email' => 'email'
        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        $recipe = Recipe::where('status_resep','publish')
                        ->where('idresep',$request->idresep)
                        ->get();

        $tools = Tool::where('resep_idresep',$request->idresep)->get();
        $ingredients = Ingredients::where('resep_idresep',$request->idresep)->get();

        $data = [];
        foreach($recipe as $recipe) {
            array_push($data,[
                'idresep' => $recipe->idresep,
                'judul' => $recipe->judul,
                'gambar' => url($recipe->gambar),
                'cara_pembuatan' => $recipe->cara_pembuatan,
                'video' => $recipe->video,
                'nama' => $recipe->user->nama
            ]);
        }

        $recipeData = [
            'recipe' => $data,
            "tools" => $tools,
            "ingredients" => $ingredients
        ];

        // memasukkan data yang melihat resep ini
        \App\Models\RecipeView::create([
            'email' => $request->email,
            'date' => now(),
            'resep_idresep' => $request->idresep
        ]);

        return response()->json($recipeData,200);

    }

    public function rating(Request $request) {
        $validator = Validator::make($request->all(), [
            'idresep' => 'required',
            'email' => 'required|email',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        if($validator->fails()) {
            return messageError($validator->messages()->toArray());
        }

        \App\Models\Rating::create([
            'rating' => $request->rating,
            'review' => $request->review,
            'resep_idresep' => $request->idresep,
            'email_user' => $request->email
        ]);

        return response()->json([
            'data' => [
                'msg' => "rating berhasil di simpan"
            ]
            ]);
    }
}
