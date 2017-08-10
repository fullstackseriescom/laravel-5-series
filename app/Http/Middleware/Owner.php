<?php

namespace App\Http\Middleware;

use Closure;
use App\Post;
use Illuminate\Support\Facades\Auth;

class Owner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $post = Post::find($request->id);

        if ($post->user_id != Auth::user()->id)
        {
            return redirect("/posts");
        }
        return $next($request);
    }
}
