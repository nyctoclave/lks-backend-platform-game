<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request){


        $token = $request->user()->currentAccessToken();
        logger('melihat token 222', ['okokokok' => $token]);

            // return response()->json([
            //     'mengecek token' => $token
            // ]);

        $admins = Admin::all();
        return response()->json([
            'status' => 'success',
            'totalelements' => count($admins),
            'data' => $admins
        ]);
    }
}
