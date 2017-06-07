<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTranslations extends Model
{
    public function language()
    {
        return $this->hasOne('\App\Models\Language', 'id', 'language_id');
    }
}
