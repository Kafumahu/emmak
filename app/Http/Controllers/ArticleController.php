<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('user', 'tags', 'commentaires')
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article)
{
    $article->load('user', 'tags', 'likes', 'commentaires.user', 'commentaires.reponses.user', 'commentaires.tags');
    return view('articles.show', compact('article'));
}
    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'contenu' => 'required|string',
            'image' => 'nullable|image|max:5120',
            'video' => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime|max:51200',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('videos', 'public');
        }

        $article = Article::create([
            'user_id' => auth()->id(),
            'titre' => $request->titre,
            'description' => $request->description,
            'contenu' => $request->contenu,
            'image' => $imagePath,
            'video' => $videoPath,
        ]);

        if ($request->tags) {
            $tagIds = [];
            foreach (explode(',', $request->tags) as $tagNom) {
                $tag = \App\Models\Tag::firstOrCreate(['nom' => trim($tagNom)]);
                $tagIds[] = $tag->id;
            }
            $article->tags()->sync($tagIds);
        }

        return redirect()->route('articles.index')->with('success', 'Article publié avec succès !');
    }
    public function destroy(Article $article)
{
    if (auth()->id() === $article->user_id) {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé !');
    }

    return redirect()->back()->with('error', 'Non autorisé !');
}
}