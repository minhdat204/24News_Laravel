@extends('admin.layouts.layoutAdmin')

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
            <h1 class="page-header">Category</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
        </div>
    </div>
    <!--Create modal-->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
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
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Create at</th>
                                    <th class="text-center">Update at</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr class="odd gradeX">
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>{{ $category->updated_at }}</td>
                                        <td>
                                            <div
                                                style="display: flex; justify-content: space-evenly;;
                                                    align-items: center; align-content: center;">
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editModal{{ $category->id }}">edit</button>
                                                <form action="{{ route('admin.category.hide', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    @if ($category->status)
                                                        <button type="submit" class="btn btn-danger">Hide</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success">Show</button>
                                                    @endif
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--edit modal-->
                                    <div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit category</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.category.update', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Name:</label>
                                                            <input type="text" class="form-control" id="recipient-name"
                                                                name="title" value="{{ $category->name }}">
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
