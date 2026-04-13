<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $games = Game::all();

        return response()->json([
            'totalelements' => count($games),
            'data' => $games
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'title' => ['required', 'min:3', 'max:60'],
            'description' => ['required', 'min:0', 'max:200'],
            
        ]);

        // mencari username di tabel user 
        $existingGame = Game::where('title', $request->title)->first();
            
        // mengecek dengan if apakah hasilnya true atau false 
        // return response dengan message username already exists (manual)
        if($existingGame){
            return response()->json([
                'status' => 'failed',
                'message' => 'nama game sudah tersedia'
            ], 400);
        }

         if($validated->fails()){
            return response()->json([
                'status' => 'invalid',
                'message' => $validated->errors(),
            ], 400);
        }

         
        $data_game = $validated->validate();

         $slug = $request->title;

        //  membuat huruf besar menjadi kecil 
         $slug = Str::lower($slug);
        //  membuat spasi menjadi -
         $slug = strtr($slug, ' ', '-');

        $data_game["slug"] = $slug;
        // logger('melihat data game', [$data_game]);

         $game = Game::create($data_game);


        return response()->json([
            'status' => 'success',
            'slug' => $game->slug
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $game = Game::where('slug', $slug)->first();

        if(!$game){
            return response()->json([
                'status' => 'not found',
                'message' => 'game does not axist'
            ], 404);
        }

        return response()->json([
            $game
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
