<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'date'];

    public function translations()
    {
        return $this->hasMany('App\Models\PostTranslation', 'post_id', 'id');
    }

    public static function scopeTranslated($query)
    {
        return $query->select('posts.*')
            ->addSelect(\DB::raw('coalesce(post_translations.title, posts.title) as title'))
            ->addSelect(\DB::raw('coalesce(post_translations.body, posts.body) as body'))
            ->leftJoin('post_translations', 'posts.id', 'post_translations.post_id')
            ->leftJoin('languages', 'post_translations.language_id', 'languages.id')
            ->where('languages.name', \App::getLocale());
    }

    public function getDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }

}
