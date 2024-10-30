@extends('admin.layouts.layoutAdmin')
@section('links')
@endsection
@section('scripts')
@endsection
@section('content')
    <section>
        <div class="row" style="margin-bottom: 20px">
            <div class="col-lg-12">
                <h1 class="page-header">Create post</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-form-label">Title:</label>
                    <input type="text" class="form-control" id="title" name="title">
                </div>
                <div class="form-group">
                    <label for="content" class="col-form-label">Content:</label>
                    <textarea class="form-control" id="editor" name="content"></textarea>
                </div>
                {{-- <div class="form-group">
                    <label for="content" class="col-form-label">Content:</label>
                    <div class="editor-container editor-container_document-editor editor-container_include-minimap editor-container_include-style"
                        id="editor-container">
                        <div class="editor-container__menu-bar" id="editor-menu-bar"></div>
                        <div class="editor-container__toolbar" id="editor-toolbar"></div>
                        <div class="editor-container__minimap-wrapper">
                            <div class="editor-container__editor-wrapper">
                                <div class="editor-container__editor">
                                    <div id="editor"></div>
                                </div>
                            </div>
                            <div class="editor-container__sidebar editor-container__sidebar_minimap">
                                <div id="editor-minimap"></div>
                            </div>
                        </div>
                    </div>
                </div> --}}

                <div class="form-group">
                    <label for="exampleInputFile">Image</label>
                    <input type="file" id="exampleInputFile" name="image_path">
                </div>
                <div class="form-group">
                    <label for="exampleInputFile">Categories</label>
                    <select class="form-control" name="category_id">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Chọn tags</label>
                    <div class="checkbox-tags">
                        @foreach ($tags as $tag)
                            <label class="btn-checkbox btn">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </section>
@endsection
