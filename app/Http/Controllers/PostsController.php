<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Language;
use App\Models\PostTranslation;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::translated()
            ->orderBy('date', 'desc')
            ->get();
        return \Response::json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->date = $request->get('date');
        if ($request->hasFile('image')) {
            $request->image->store('public/images');
            $fileName = $request->image->hashName();
            $post->image = 'images/'.$fileName;
        }
        $post->save();
        $translations = $request->get('postTranslations');
        foreach ($translations as $translation) {
            $translation = json_decode($translation);
            if ($translation->title == '') {
                continue;
            }
            $postTranslation = new PostTranslation();
            $postTranslation->title = $translation->title;
            $postTranslation->body = $translation->body;
            $postTranslation->language_id = $translation->language_id;
            $post->translations()->save($postTranslation);
        }
        $post = Post::translated()->find($post->id);
        return \Response::json($post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        if ('' != $post->image) {
            $res = \Storage::delete('public/'.$post->image);
        }
        if ($post->delete()) {
            return \Response::json('Post deleted');
        }
        return \Response::json("Post not found", 400);
    }
}
