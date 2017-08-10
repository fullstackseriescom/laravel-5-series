@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
      <div class="col-md-8 col-md-offset-2">
        
        <h3>{{ $post->title }}</h3>
        <div>
          {!! $post->body !!}
          <p>By {{ $post->user->name }}</p>
        </div>
        <h3>Comments</h3>
        @if (Auth::check())
          @include('includes.errors')
          {{ Form::open(['route' => ['comments.store'], 'method' => 'POST']) }}
          <p>{{ Form::textarea('body', Input::old('body')) }}</p>
          {{ Form::hidden('post_id', $post->id) }}
          <p>{{ Form::submit('Send') }}</p>
        {{ Form::close() }}
        @endif
        @forelse ($post->comments as $comment)
          <p>{{ $comment->user->name }} {{$comment->created_at}}</p>
          <p>{{ $comment->body }}</p>
          <hr>
        @empty
          <p>This post has no comments</p>
        @endforelse

    </div>
  </div>
</div>
@endsection