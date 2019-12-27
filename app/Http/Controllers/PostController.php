<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost as StorePostRequest;
use App\Http\Requests\UpdaPost as UpdatePostRequest;
use App\post;
use Auth;
use Gate;

class PostController extends Controller
{
    public function index()
    {
        $posts = post::published()->paginate();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->only('title', 'body');
        $data['slug'] = str_slug($data['title']);
        $data['user_id'] = Auth::user()->id;
        $post = post::create($data);
        return redirect()->route('edit_post', ['id' => $post->id]);
    }

    public function drafts()
    {
        $postsQuery = post::unpublished();
        if (Gate::denies('see-all-drafts')) {
            $postsQuery = $postsQuery->where('user_id', Auth::user()->id);
        }
        $posts = $postsQuery->paginate();
        return view('posts.drafts', compact('posts'));
    }

    public function edit(post $post)
    {
        return view('posts.edit', compact('post'));
    }
    public function update(post $post, UpdatePostRequest $request)
    {
        $data = $request->only('title', 'body');
        $data['slug'] = str_slug($data['title']);
        $post->fill($data)->save();
        return back();
    }

    public function publish(post $post)
    {
        $post->published = true;
        $post->save();
        return back();
    }

    public function show($id)
    {
        $post = post::published()->findOrFail($id);
        return view('posts.show', compact('post'));
    }
}
