<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'article_id',
        'parent_id',
        'contenu',
        'mentions',
        'mentions',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function parent()
    {
        return $this->belongsTo(Commentaire::class, 'parent_id');
    }

    public function reponses()
    {
        return $this->hasMany(Commentaire::class, 'parent_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}