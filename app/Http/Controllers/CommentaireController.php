<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class CommentaireController extends Controller
{
    public function store(Request $request, $articleId)
    {
        $request->validate([
            'contenu' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:commentaires,id',
        ]);

        // Détecter les @mentions dans le contenu
        preg_match_all('/@(\w+)/', $request->contenu, $matches);
        $mentions = implode(',', $matches[1]);

        $commentaire = Commentaire::create([
            'user_id' => auth()->id(),
            'article_id' => $articleId,
            'parent_id' => $request->parent_id,
            'contenu' => $request->contenu,
            'mentions' => $mentions,
        ]);

        if ($request->tags) {
            $tagIds = [];
            foreach (explode(',', $request->tags) as $tagNom) {
                $tag = Tag::firstOrCreate(['nom' => trim($tagNom)]);
                $tagIds[] = $tag->id;
            }
            $commentaire->tags()->sync($tagIds);
        }

        return back()->with('success', 'Commentaire ajouté !');
    }

    public function destroy(Commentaire $commentaire)
    {
        if (auth()->id() === $commentaire->user_id) {
            $commentaire->delete();
        }

        return back()->with('success', 'Commentaire supprimé !');
    }
}