@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">

      @include('includes.errors')

      {{ Form::model($post, ['route' => ['posts.update', $post->id], 'method' => 'PATCH']) }}
        <p>{{ Form::text('title', Input::old('title')) }}</p>
        <p>{{ Form::textarea('body', Input::old('body'), ['class' => 'textarea-wysiwyg']) }}</p>
        <p>{{ Form::submit('Save', ['name' => 'submit']) }}</p>
      {{ Form::close() }}
    </div>
  </div>
</div>
@endsection