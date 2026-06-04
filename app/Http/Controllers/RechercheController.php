<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Http\Request;

class RechercheController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->q;
        $users = collect();
        $articles = collect();

        if ($query) {
            $users = User::where('name', 'like', "%$query%")->get();
            $articles = Article::with('user', 'tags')
                ->where('titre', 'like', "%$query%")
                ->orWhere('description', 'like', "%$query%")
                ->latest()
                ->get();
        }

        return view('recherche.index', compact('query', 'users', 'articles'));
    }
}