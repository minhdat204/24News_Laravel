@extends('admin.layouts.layoutAdmin')

@section('content')
    <section>
        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-12">
                <h1 class="page-header">Edit post</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <form action="{{ route('admin.post.update', $post->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="recipient-name" name="title"
                        value="{{ $post->title }}">
                </div>
                <div class="form-group">
                    <label for="message-text" class="col-form-label">Content:</label>
                    <textarea class="form-control" id="message-text" name="content">{{ $post->content }}</textarea>
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <input type="file" id="exampleInputFile" name="image_path" value="{{ $post->image_path }}">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Categories</label>
                    <select class="form-control" name="category_id">
                        @foreach ($categories as $category)
                            @if ($category->id == $post->category_id)
                                <option value="{{ $category->id }}" selected>
                                    {{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Chọn tags</label>
                    <div class="checkbox-tags">
                        @foreach ($tags as $tag)
                            <label class="btn-checkbox btn">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                    @if ($post->tags->contains($tag->id)) checked @endif>
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Edit</button>
            </div>
        </form>
    </section>
@endsection
