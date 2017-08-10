@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-6 col-md-offset-1">
        <h3>Posts</h3>

        {{ Form::open(['route' => ['posts.index'], 'method' => 'GET']) }}
          <p>{{ Form::text('search', Input::old('search'), array('placeholder'=>'Search')) }}</p>
          <p>{{ Form::submit('Search') }}</p>
        {{ Form::close() }}

        @if (Auth::check() && Auth::user()->hasPermissionTo('post_create'))
          <h4>Create post</h4>
          @include('includes.errors')
          @include('includes.form-submit-post')
        @endif

        @forelse ($posts as $post)
            <h4>{{ $post->title }}</h4>
            <span>{{$post->comments->count()}} {{ str_plural('comment', $post->comments->count()) }}</span>
            <p>By {{ $post->user->name }} on {{ $post->created_at }}</p>
            <a href="{{URL::to('/')}}/post/{{ $post->id }}">Go</a>
            @if (Auth::check() && ($post->user_id == Auth::id() || Auth::user()->hasRole('administrator')))
              <a href="{{URL::to('/')}}/post/{{ $post->id }}/edit">Edit</a>
              <form action="{{URL::to('/')}}/post/{{ $post->id }}" method="POST">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}

                  <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
              </form>
            @endif  
        @empty
          <p>No posts</p>
        @endforelse

        @if (count($posts))
          {{-- $posts->links() --}}
          @include('includes.pagination', ['paginator' => $posts])
        @endif

      </div>
      <div class="col-md-2 col-md-offset-1">
        <h3>Active users</h3>
        @forelse ($active_users as $user)
            <p>{{ $user->name }} ({{ $user->last_login->diffForHumans() }})</p>
        @empty
          <p>No users</p>
        @endforelse
      </div>

    </div>
  </div>
</div>
@endsection
