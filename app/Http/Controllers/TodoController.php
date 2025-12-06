<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    public function index(Request $request)
    {
        $query = Todo::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->is_done !== null) {
            $query->where('is_done', $request->is_done);
        }

        $todos = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $todos
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'is_done' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $todo = Todo::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Todo created successfully',
            'data' => $todo
        ], 201);
    }

    public function show($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json([
                'success' => false,
                'message' => 'Todo not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $todo
        ]);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['success' => false, 'message' => 'Todo not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'description' => 'nullable|string',
            'is_done' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $todo->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Todo updated successfully',
            'data' => $todo
        ]);
    }

    public function destroy($id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return response()->json(['success' => false, 'message' => 'Todo not found'], 404);
        }

        $todo->delete();

        return response()->json(['success' => true, 'message' => 'Todo deleted successfully']);
    }
}

