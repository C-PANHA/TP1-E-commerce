<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Audience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    /**
     * Subscribe an audience to an article.
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audience_id' => 'required|exists:audiences,id',
            'article_id' => 'required|exists:articles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $audience = Audience::find($request->audience_id);
        $article = Article::find($request->article_id);

        if ($audience->articles()->where('article_id', $request->article_id)->exists()) {
            return response()->json(['message' => 'Already subscribed'], 409);
        }

        $audience->articles()->attach($request->article_id);

        return response()->json(['message' => 'Subscribed successfully']);
    }

    /**
     * Unsubscribe an audience from an article.
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audience_id' => 'required|exists:audiences,id',
            'article_id' => 'required|exists:articles,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $audience = Audience::find($request->audience_id);
        $audience->articles()->detach($request->article_id);

        return response()->json(['message' => 'Unsubscribed successfully']);
    }

    /**
     * Get subscribers of an article.
     */
    public function getSubscribers($articleId)
    {
        $article = Article::findOrFail($articleId);
        $subscribers = $article->audiences()->with('user')->get();

        return response()->json($subscribers);
    }

    /**
     * Get subscriptions of an audience.
     */
    public function getSubscriptions($audienceId)
    {
        $audience = Audience::findOrFail($audienceId);
        $subscriptions = $audience->articles()->with('author')->get();

        return response()->json($subscriptions);
    }
}