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
            <h1 class="page-header">Contact</h1>
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
                    <h5 class="modal-title" id="createModalLabel">Create contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.contact.store') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" class="form-control" id="recipient-name" name="email">
                        </div>
                        <div class="form-group">
                            <label for="subject" class="col-form-label">Subject:</label>
                            <input type="text" class="form-control" id="recipient-name" name="subject">
                        </div>
                        <div class="form-group">
                            <label for="message" class="col-form-label">Message:</label>
                            <textarea class="form-control" id="message-text" name="message"></textarea>
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
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Subject</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Create at</th>
                                    <th class="text-center">Update at</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                    <tr class="odd gradeX">
                                        <td>{{ $contact->name }}</td>
                                        <td>{{ $contact->email }}</td>
                                        <td>{{ $contact->subject }}</td>
                                        <td>
                                            @if ($contact->status == 0)
                                                <span class="label label-default">Chưa xử lý</span>
                                            @elseif ($contact->status == 1)
                                                <span class="label label-warning">Đang xử lý</span>
                                            @elseif($contact->status == 2)
                                                <span class="label label-success">Đã xử lý</span>
                                            @endif
                                        </td>
                                        <td>{{ $contact->created_at }}</td>
                                        <td>{{ $contact->updated_at }}</td>
                                        <td>
                                            <div
                                                style="display: flex; justify-content: space-evenly;;
                                                    align-items: center; align-content: center;">
                                                <button type="button" class="btn btn-warning" data-toggle="modal"
                                                    data-target="#editModal{{ $contact->id }}">edit</button>
                                                <form action="{{ route('admin.contact.destroy', $contact->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <button type="submit" class="btn btn-danger">Delete</button>

                                                </form>
                                                <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#showMessage{{ $contact->id }}">Show</button>
                                                <!-- Modal show message-->
                                                <div class="modal fade" id="showMessage{{ $contact->id }}" tabindex="-1"
                                                    role="dialog" aria-labelledby="showMessageLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal"
                                                                    aria-hidden="true">&times;</button>
                                                                <h4 class="modal-title" id="showMessageLabel">Message</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                {{ $contact->message }}
                                                            </div>
                                                            <div class="modal-footer"
                                                                style="display:flex; justify-content: end">
                                                                <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal"
                                                                    style="margin-right: 5px">Close</button>
                                                                <form
                                                                    action="{{ route('admin.contact.status', $contact->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <select class="form-control" name="status">
                                                                        <option value="0"
                                                                            @if ($contact->status == 0) selected @endif>
                                                                            Chưa xử lý
                                                                        </option>
                                                                        <option value="1"
                                                                            @if ($contact->status == 1) selected @endif>
                                                                            Đang xử lý
                                                                        </option>
                                                                        <option value="2"
                                                                            @if ($contact->status == 2) selected @endif>
                                                                            Đã xử lý
                                                                        </option>
                                                                    </select>

                                                                    <button type="submit"
                                                                        class="btn btn-primary">OK</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <!-- /.modal -->
                                            </div>
                                        </td>
                                    </tr>
                                    <!--edit modal-->
                                    <div class="modal fade" id="editModal{{ $contact->id }}" tabindex="-1"
                                        aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit contact</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.contact.update', $contact->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name" class="col-form-label">Name:</label>
                                                            <input type="text" class="form-control"
                                                                id="recipient-name" name="name"
                                                                value="{{ $contact->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email" class="col-form-label">Email:</label>
                                                            <input type="text" class="form-control"
                                                                id="recipient-name" name="email"
                                                                value="{{ $contact->email }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="subject" class="col-form-label">Subject:</label>
                                                            <input type="text" class="form-control"
                                                                id="recipient-name" name="subject"
                                                                value="{{ $contact->subject }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message" class="col-form-label">Message:</label>
                                                            <textarea class="form-control" id="message-text" name="message">{{ $contact->message }}</textarea>
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
