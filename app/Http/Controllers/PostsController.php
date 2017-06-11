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
        $posts = Post::translated()->get();
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
        $post->title = $request->get('title');
        $post->body = $request->get('body');
        $post->date = $request->get('date');
        $post->save();
        $languages = Language::all();
        foreach ($languages as $language) {
            $title = "title_".$language->title;
            if ($title != '') {
                $postTranslation = new PostTranslation(
                    [
                        'language_id' => $language->id,
                        'title' => $request->get('title_'.$language->name),
                        'body' => $request->get('body_'.$language->name)
                    ]
                );
                $post->translations()->save($postTranslation);
            }
        }
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
        if (Post::destroy($id)) {
            return \Response::json('Post deleted');
        }
        return \Response::json("Post not found", 400);
    }
}
