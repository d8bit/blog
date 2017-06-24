<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Language;

class LanguagesController extends Controller
{
    public function index()
    {
        $languages = Language::all();
        return \Response::json($languages);
    }
}
