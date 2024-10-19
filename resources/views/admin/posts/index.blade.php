@extends('admin.layouts.layoutAdmin')
@section('links')
    <link rel="stylesheet" href="{{ asset('admin/css/posts/post.css') }}">
@endsection
@section('scripts')
    <!-- DataTables JavaScript -->
    <script src="{{ asset('admin/js/dataTables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/dataTables/dataTables.bootstrap.min.js') }}"></script>
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
@endsection
@section('content')
    <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-12">
            <h1 class="page-header">Posts</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!--Create modal-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="name" name="title">
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-form-label">Content:</label>
                            <textarea class="form-control" id="content" name="content"></textarea>
                        </div>
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
            </div>
        </div>
    </div>
    <!--End create modal-->
    <!-- /.row -->
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">

                <!-- /.panel-heading -->
                <div class="panel-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <div style="position: relative; z-index:1">
                                    <div style="position: absolute; right:0; z-index: 2;">
                                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                                            data-target="#createModal" aria-expanded="false">Create</button>
                                    </div>
                                </div>
                                <tr>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Content</th>
                                    <th class="text-center">Image_path</th>
                                    <th class="text-center">Author</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Tags</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Create at</th>
                                    <th class="text-center">Update at</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr class="odd gradeX">
                                        <td>{{ $post->title }}</td>
                                        <td>{{ $post->content }}</td>
                                        <td>{{ $post->image_path }}</td>
                                        <td>{{ $post->author->name }}</td>
                                        <td>{{ $post->category->name }}</td>
                                        <td class="text-center">
                                            @foreach ($post->tags as $tag)
                                                <span class="badge"
                                                    style="background-color:cornflowerblue">{{ $tag->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-center">
                                            @if ($post->status == 1)
                                                <span class="badge" style="background-color: green">activate</span>
                                            @else
                                                <span class="badge">deactivate</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->created_at }}</td>
                                        <td>{{ $post->updated_at }}</td>
                                        <td>
                                            <div
                                                style="display: flex; justify-content: space-evenly;;
                                                align-items: center; align-content: center;">
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editModal{{ $post->id }}">edit</button>
                                                <form action="{{ route('admin.post.hide', $post->id) }}" method="POST">
                                                    @csrf
                                                    @if ($post->status == 1)
                                                        <button type="submit" class="btn btn-danger">hide</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success">show</button>
                                                    @endif
                                                </form>
                                                <button class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal{{ $post->id }}">delete</button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!--delete modal-->
                                    <div class="modal fade" id="deleteModal{{ $post->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Delete post</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Are you sure
                                                                delete this post?</label>
                                                        </div>
                                                        <div class="form-group">
                                                            <div id="recaptcha_{{ $post->id }}"></div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end delete modal-->
                                    <!--edit modal-->
                                    <div class="modal fade" id="editModal{{ $post->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit post</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.post.update', $post->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Title:</label>
                                                            <input type="text" class="form-control"
                                                                id="recipient-name" name="title"
                                                                value="{{ $post->title }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text"
                                                                class="col-form-label">Content:</label>
                                                            <textarea class="form-control" id="message-text" name="content">{{ $post->content }}</textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputFile">Image</label>
                                                            <input type="file" id="exampleInputFile" name="image_path"
                                                                value="{{ $post->image_path }}">
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
                                                                        <input type="checkbox" name="tags[]"
                                                                            value="{{ $tag->id }}"
                                                                            @if ($post->tags->contains($tag->id)) checked @endif>
                                                                        {{ $tag->name }}
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Edit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end edit modal-->
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
