<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $query = Note::query();

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->title) {
            $query->where('title', 'like', "%{$request->title}%");
        }

        $notes = $query->orderBy('updated_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $notes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|integer',
            'title' => 'required|string',
            'content' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $note = Note::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Note created successfully',
            'data' => $note
        ], 201);
    }

    public function show($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $note]);
    }

    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'content' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $note->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Note updated successfully',
            'data' => $note
        ]);
    }

    public function destroy($id)
    {
        $note = Note::find($id);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Note not found'], 404);
        }

        $note->delete();

        return response()->json(['success' => true, 'message' => 'Note deleted successfully']);
    }
}

