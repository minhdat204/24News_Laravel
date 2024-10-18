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
    <!--ajax delete category-->
    <script src="{{ asset('admin/js/ajaxConfirm.js') }}"></script>

    <!--auto reset capcha-->


    <!--capcha v2-->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                <form action="{{ route('admin.category.store') }}" method="POST">
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
                                    <tr class="odd gradeX" id="category_{{ $category->id }}">
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->created_at }}</td>
                                        <td>{{ $category->updated_at }}</td>
                                        <td>
                                            <div
                                                style="display: flex; justify-content: space-evenly;;
                                                    align-items: center; align-content: center;">
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editModal{{ $category->id }}">edit</button>
                                                <!--ẩn danh mục-->
                                                {{-- <form action="{{ route('admin.category.hide', $category->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    @if ($category->status)
                                                        <button type="submit" class="btn btn-danger">Hide</button>
                                                    @else
                                                        <button type="submit" class="btn btn-success">Show</button>
                                                    @endif
                                                </form> --}}
                                                <!--xóa danh mục-->
                                                <!-- Nút Xóa -->
                                                {{-- <button class="btn btn-danger delete-btn"
                                                    data-id="{{ $category->id }}">Xóa</button>

                                                <!-- Modal xác nhận xóa -->
                                                <div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Xác nhận xóa</h5>
                                                                <button type="button" class="close" data-dismiss="modal"
                                                                    aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Bạn có chắc muốn xóa danh mục này không?</p>
                                                                <form id="deleteForm">
                                                                    <input type="hidden" id="categoryId">
                                                                    <!-- CAPTCHA -->
                                                                    <div class="g-recaptcha"
                                                                        data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Hủy</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    id="confirmDelete">Xóa</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                                <button type="button" class="btn btn-danger pull-right" data-toggle="modal"
                                                    data-target="#deleteModal{{ $category->id }}"
                                                    aria-expanded="false">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <!--delete modal-->
                                    <div class="modal fade" id="deleteModal{{ $category->id }}" tabindex="-1"
                                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="createModalLabel">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form id="deleteForm">
                                                    <div class="modal-body">
                                                        <p>Bạn có chắc muốn xóa danh mục này không?</p>

                                                        <div class="form-group">
                                                            <input type="hidden" class="categoryId"
                                                                value="{{ $category->id }}">
                                                            <!-- CAPTCHA -->
                                                            <div class="g-recaptcha"
                                                                data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-danger confirmDelete"
                                                            onclick="confirmDelete({{ $category->id }})">Delete</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
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
                                                            <input type="text" class="form-control"
                                                                id="recipient-name" name="name"
                                                                value="{{ $category->name }}">
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
