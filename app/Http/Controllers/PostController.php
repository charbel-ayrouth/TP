<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //eager loading
        $posts = Post::orderBy('created_at', 'desc')->with(['user', 'likes'])->paginate(20);
        return view('posts.index', [
            'posts' => $posts
        ]);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
        $request->user()->posts()->create($request->only('body'));
        // $request->user()->posts()->create([
        //     'body' => $request->body
        // ]);
        return back();
    }
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post); //policy we defined in PostPolicy
        $post->delete();
        return back();
    }
}
