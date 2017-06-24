<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslation extends Model
{
    protected $fillable = ['language_id', 'title', 'body'];

    public function language()
    {
        return $this->hasOne('\App\Models\Language', 'id', 'language_id');
    }
}
