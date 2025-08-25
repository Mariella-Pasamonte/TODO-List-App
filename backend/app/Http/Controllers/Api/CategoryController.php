<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function add(Request $request){
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'user_id' => 'required|integer',
            ]);
            
            DB::table('categories')->insert([
                'name'=>$request->name,
                'user_id'=>$request->user_id,
            ]);

            return response()->json(["message"=>"Add Category Success"], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation failed
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Any other error
            Log::error('Adding category failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while adding category.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
