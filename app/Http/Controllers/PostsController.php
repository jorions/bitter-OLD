<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return App\Post::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new App\Post;

        $post->user_id = \Auth::user()->id;
        $post->content = $request->post_content;

        $post->save();

        return $post;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return App\Post::with('user.likes')->find($id);
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
        $post = App\Post::find($id);

        // Make sure the user is the owner of the post
        if($post->user_id == \Auth::user()->id) {
            $post->content = $request->post_content;
            $post->save();
            return $post;
        }

        return response("Unauthorized", 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = App\Post::find($id);

        // Make sure the user is the owner of the post
        if($post->user_id == \Auth::user()->id) {
            $post->delete();
            return $post;
        }

        return response("Unauthorized", 403);
    }
}
