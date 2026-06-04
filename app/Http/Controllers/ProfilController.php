<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        $articles = $user->articles()->with('tags', 'commentaires')->latest()->paginate(10);
        return view('profil.show', compact('user', 'articles'));
    }

    public function monProfil()
    {
        $user = auth()->user();
        $articles = $user->articles()->with('tags', 'commentaires')->latest()->paginate(10);
        return view('profil.show', compact('user', 'articles'));
    }
}
