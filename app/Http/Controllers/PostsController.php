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
        $posts = Post::with('translations.language')
            ->orderBy('date', 'desc')
            ->get();
        return \Response::json($posts);
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
            $postTranslation = new PostTranslation();
            $postTranslation->title = $translation->title;
            $postTranslation->body = $translation->body;
            $postTranslation->language_id = $translation->language_id;
            $post->translations()->save($postTranslation);
        }
        $post = Post::with('translations.language')
            ->findOrFail($post->id);
        return \Response::json($post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId)
    {
        $post = Post::with('translations')->findOrFail($postId);
        $post->date = $request->input('date');
        if ($request->hasFile('imageField')) {
            $request->imageField->store('public/images');
            $fileName = $request->imageField->hashName();
            $post->image = 'images/'.$fileName;
        }
        if (!$request->hasFile('imageField') && '' == $request->input('image')) {
            if (\Storage::exists('public/'.$post->image) && '' != $post->image) {
                \Storage::delete('public/'.$post->image);
            }
            $post->image = '';
        }
        $post->save();
        $postTranslations = $request->input('postTranslations');
        if (0 == count($postTranslations)) {
            return \Response::json($post);
        }
        foreach ($postTranslations as $postTranslation) {
            $postTranslation = json_decode($postTranslation);
            $translation = PostTranslation::findOrFail($postTranslation->id);
            $translation->title = $postTranslation->title;
            $translation->body = $postTranslation->body;
            $translation->save();
        }
        return \Response::json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        try {
            $post = Post::findOrFail($postId);
        } catch (\Exception $e) {
            return \Response::json("Post not found", 400);
        }

        if ('' != $post->image) {
            \Storage::delete('public/'.$post->image);
        }
        if ($post->delete()) {
            return \Response::json('Post deleted');
        }
        return \Response::json("Post not deleted", 400);
    }
}
