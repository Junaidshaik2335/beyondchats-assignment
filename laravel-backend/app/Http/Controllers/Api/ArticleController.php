<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    // GET /api/articles
    public function index()
    {
        return Article::latest()->get();
    }

    // POST /api/articles
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'type' => 'required|in:original,generated',
            'source_url' => 'nullable|string',
        ]);

        $article = Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'content' => $request->content,
            'source_url' => $request->source_url,
            'type' => $request->type,
        ]);

        return response()->json($article, 201);
    }

    // GET /api/articles/{id}
    public function show($id)
    {
        return Article::findOrFail($id);
    }

    // PUT /api/articles/{id}
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $article->update($request->all());
        return response()->json($article);
    }

    // DELETE /api/articles/{id}
    public function destroy($id)
    {
        Article::destroy($id);
        return response()->json(['message' => 'Article deleted successfully']);
    }
}
