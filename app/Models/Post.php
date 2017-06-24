<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['image', 'date'];

    public function translations()
    {
        return $this->hasMany('App\Models\PostTranslation', 'post_id', 'id');
    }

    public static function scopeTranslated($query)
    {
        return $query->select('posts.*')
            ->addSelect('post_translations.title as title')
            ->addSelect('post_translations.body as body')
            ->leftJoin('post_translations', 'posts.id', 'post_translations.post_id')
            ->leftJoin('languages', 'post_translations.language_id', 'languages.id')
            ->orderBy('language_id', 'date')
            ->groupBy('post_id');
    }

    public function getDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

}
