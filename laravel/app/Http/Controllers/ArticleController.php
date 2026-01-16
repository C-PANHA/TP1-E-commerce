<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Get all articles.
     */
    public function index()
    {
        $articles = Article::with(['author', 'audiences'])->get();
        return response()->json($articles);
    }

    /**
     * Create a new article.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author_id' => 'required|exists:authors,id',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article = Article::create($request->all());

        return response()->json([
            'message' => 'Article created successfully',
            'article' => $article->load(['author', 'audiences']),
        ], 201);
    }

    /**
     * Get a specific article.
     */
    public function show($id)
    {
        $article = Article::with(['author', 'audience', 'comments'])->findOrFail($id);
        return response()->json($article);
    }

    /**
     * Update an article.
     */
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required|string',
            'author_id' => 'sometimes|required|exists:authors,id',
            'published_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $article->update($request->all());

        return response()->json([
            'message' => 'Article updated successfully',
            'article' => $article->load(['author', 'audiences']),
        ]);
    }

    /**
     * Delete an article.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(['message' => 'Article deleted successfully']);
    }

    /**
     * Get all articles by author ID.
     */
    public function getByAuthor($authorId)
    {
        $articles = Article::where('author_id', $authorId)->with(['author', 'audiences'])->get();
        return response()->json($articles);
    }
}