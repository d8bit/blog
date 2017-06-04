<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'body', 'date'];

    public function getDateAttribute($value)
    {
        return date("d/m/Y", strtotime($value));
    }
}
