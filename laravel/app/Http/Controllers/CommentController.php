<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Get all comments.
     */
    public function index()
    {
        $comments = Comment::with(['user', 'commentable'])->get();
        return response()->json($comments);
    }

    /**
     * Create a new comment.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|integer',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment = Comment::create($request->all());

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment->load(['user', 'commentable']),
        ], 201);
    }

    /**
     * Get a specific comment.
     */
    public function show($id)
    {
        $comment = Comment::with(['user', 'commentable'])->findOrFail($id);
        return response()->json($comment);
    }

    /**
     * Update a comment.
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'content' => 'sometimes|required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $comment->update($request->only('content'));

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $comment->load(['user', 'commentable']),
        ]);
    }

    /**
     * Delete a comment.
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }

    /**
     * Get all comments by user ID.
     */
    public function getByUser($userId)
    {
        $comments = Comment::where('user_id', $userId)->with(['user', 'commentable'])->get();
        return response()->json($comments);
    }

    /**
     * Get all comments on a specific commentable (audience, article, author).
     */
    public function getByCommentable($type, $id)
    {
        $comments = Comment::where('commentable_type', $type)->where('commentable_id', $id)->with(['user', 'commentable'])->get();
        return response()->json($comments);
    }
}