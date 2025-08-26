<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Tasks;

class TasksController extends Controller
{
    public function getByUser(Request $request)
    {
        try{
            $userId = $request->query('user_id');

            $tasks = Tasks::where('user_id', (int)$userId)->get();

            $tasks = $tasks->map(function($task){
                return[
                    'id'        => $task->id,
                    'name'         => $task->name,
                    'description'  => $task->description,
                    'isCompleted'  => (bool)$task->isCompleted,
                    'dueDate'      => $task->dueDate,
                    'category'     => $task->category ? $task->category->name : null,
                    'category_id'  => $task->category_id,
                ];
            });

            return response()->json([
                'message' => 'Get tasks successful!',
                'tasks'=> $tasks,
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong while getting task.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function updateIsCompleted(Request $request, $id)
    {
        try{
            $request->validate([
                'isCompleted' => 'required|boolean',
            ]);
            
            $task = Tasks::where('id', $id)->first();  
            $task->isCompleted = $request->isCompleted;
            $task->updated_at = now();
            $task->save();

            return response()->json([
                'message' => 'Task updated successfully!',
                'tasks'=> $task,
            ], 200);
        }catch (\Exception $e){
            return response()->json([
                'message' => 'Something went wrong while updating isCompleted.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function addTask(Request $request){
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'isCompleted' => 'boolean',
                'dueDate' => 'nullable|date',
                'category_id' => 'nullable|integer',
                'user_id' => 'required|integer',
            ]);
            
            DB::table('tasks')->insert([
                'name'          => $request->name,
                'description'   => $request->description,
                'isCompleted'   => $request->isCompleted,
                'dueDate'       => $request->dueDate,
                'category_id'   => $request->category_id,
                'user_id'       => $request->user_id,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);

            return response()->json(["message"=>"Add Task Success"], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Adding Task failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while adding task.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function editTask(Request $request,$id){
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:500',
                'dueDate' => 'nullable|date',
                'category_id' => 'nullable|integer',
            ]);
            
            $task = Tasks::where('id', $id)->first();
            $task -> name          = $request -> name;
            $task -> description   = $request -> description;
            $task -> dueDate       = $request -> dueDate;
            $task -> category_id   = $request -> category_id;
            $task -> updated_at    = now();
            $task->save();

            return response()->json([
                "message"=>"Edit Task Success"
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Editing Task failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while editing task.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function fetchTask($id){
        try {
            $task = Tasks::where('id', $id)->first();

            return response()->json([
                'message' => 'Task fetched successfully!',
                'task'=> $task,
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Fetching error',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Fetching Task failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Something went wrong while fetchings task.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
    
    public function delete($id){
        try{
            $task = Tasks::where('id', $id)->first();
            $task->delete();
            return response()->json(['message' => 'Task deleted successfully'], 200);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong while deleting task.',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }
}
