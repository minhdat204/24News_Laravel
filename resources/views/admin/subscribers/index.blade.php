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
    <script>
        // Handle "Select All" functionality
        document.getElementById('select-all').addEventListener('click', function(event) {
            let checkboxes = document.querySelectorAll('input[name="subscriber_ids[]"]');
            checkboxes.forEach((checkbox) => {
                checkbox.checked = event.target.checked;
            });
        });
    </script>
@endsection

@section('content')
    <div class="row" style="margin-bottom: 20px">
        <div class="col-lg-12">
            <h1 class="page-header">Subscribers</h1>
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
                    <h5 class="modal-title" id="createModalLabel">Create subscribe</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.subscribe.store') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="email" name="email">
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
                        <form action="{{ route('admin.subscribe.bulkActions') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div>
                                <select name="action">
                                    <option value="delete">Delete</option>
                                    <option value="activate">Activate</option>
                                    <option value="export">Export</option>
                                </select>

                                <button type="submit">Apply</button>
                            </div>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <div style="position: relative; z-index:1">
                                    <div style="position: absolute; right:0; z-index: 2;">
                                        <button type="button" class="btn btn-primary pull-right" data-toggle="modal"
                                            data-target="#createModal" aria-expanded="false">Create</button>
                                    </div>
                                </div>
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="select-all"> Select All</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Subscribed_at</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subscribers as $subscribe)
                                        <tr class="odd gradeX">
                                            <td><input type="checkbox" name="subscriber_ids[]" value="{{ $subscribe->id }}">
                                            </td>
                                            <td>{{ $subscribe->email }}</td>
                                            <td>{{ $subscribe->subscribed_at }}</td>
                                            <td>
                                                <div
                                                    style="display: flex; justify-content: space-evenly;;
                                                    align-items: center; align-content: center;">
                                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                                        data-target="#editModal{{ $subscribe->id }}">edit</button>
                                                    <form action="{{ route('admin.subscribe.destroy', $subscribe->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <!--edit modal-->
                                        <div class="modal fade" id="editModal{{ $subscribe->id }}" tabindex="-1"
                                            aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit subscribe</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('admin.subscribe.update', $subscribe->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="email" class="col-form-label">Email:</label>
                                                                <input type="text" class="form-control"
                                                                    id="recipient-email" name="email"
                                                                    value="{{ $subscribe->email }}">
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

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
