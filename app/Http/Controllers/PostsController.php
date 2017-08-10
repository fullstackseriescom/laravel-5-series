<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class PostsController extends Controller
{
  public function __construct() {
    // $this->middleware('auth')->only('store');
  }

  public function show($id) {
    $post = Post::findOrFail($id);
    return view('post', ['post' => $post]);
  }

  public function index() {
    // https://stackoverflow.com/a/30298599 -- custom pagination

    // $posts = Post::where('title', 'like', '%'.Input::get('search').'%')
    //               ->orWhere('body', 'like', '%'.Input::get('search').'%')
    //               ->orderBy('id', 'desc')->paginate(6);

    // https://packagist.org/packages/sofa/eloquence -- search package
    // https://github.com/jarektkaczyk/eloquence/wiki/Builder-searchable-and-more
    $posts = Post::search(Input::get('search'))->orderBy('id', 'desc')->paginate(6);
    $active_users = User::active()->get(); 
    
    return view('posts', ['posts' => $posts, 'active_users' => $active_users]);
  }

  public function store(PostRequest $request) {
    $this->authorize('create', Post::class);
    Post::create([
      'title' => $request->title,
      'body' => $request->body,
      'user_id' => Auth::id()
    ]);
    return redirect('posts');
  }

  public function edit(Request $request) {
    $post = Post::findOrFail($request->id);
    $this->authorize('update', $post);
    return view('post_edit', ['post' => $post]);
  }

  public function update(PostRequest $request) {
    $post = Post::findOrFail($request->id);
    $this->authorize('update', $post);
    $post->update([
      'title' => $request->title,
      'body' => $request->body
    ]);

    return redirect('posts');
  }

  public function destroy(Request $request) {

    $post = Post::findOrFail($request->id);
    $this->authorize('delete', $post);
    $post->delete();

    return redirect('posts');
  }
}
