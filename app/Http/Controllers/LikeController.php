<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Article;
use App\Models\Notification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function toggle($articleId)
    {
        $article = Article::findOrFail($articleId);
        $userId = auth()->id();

        $like = Like::where('user_id', $userId)
            ->where('article_id', $articleId)
            ->first();

        if ($like) {
            // Déjà liké → enlever le like
            $like->delete();
            $liked = false;
        } else {
            // Pas encore liké → ajouter le like
            Like::create([
                'user_id' => $userId,
                'article_id' => $articleId,
            ]);
            $liked = true;

            // Envoyer notification au propriétaire si ce n'est pas soi-même
            if ($article->user_id !== $userId) {
                Notification::create([
                    'user_id' => $article->user_id,
                    'from_user_id' => $userId,
                    'article_id' => $articleId,
                    'type' => 'like',
                    'lu' => false,
                ]);
            }
        }

        return response()->json([
            'liked' => $liked,
            'total' => $article->likes()->count(),
        ]);
    }
}