<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'date'];

    public function translations()
    {
        return $this->hasMany('App\Models\PostTranslations');
    }

    public function getDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}
