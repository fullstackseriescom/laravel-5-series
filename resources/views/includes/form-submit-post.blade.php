<form id="save_post" method="post" action="{{URL::to('/')}}/posts">
  {{ csrf_field() }}
  <div>
    <p>Title</p>
    <input type="text" id="title" name="title" value="{{ old('title') }}">
  </div>
  
  <div>
    <p>Body</p>
    <textarea class="textarea-wysiwyg" id="body" name="body">{{ old('body') }}</textarea>
  </div>
  
  <div>
    <input type="submit" value="Save">
  </div>
</form>