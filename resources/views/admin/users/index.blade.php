@extends('layouts.app')

@section('title', 'Users')

@section('usersActive', 'active')

@section('css')
    <!-- DataTables Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}">

    <!-- DataTables Extensions -->

    {{-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/AutoFill/css/autoFill.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/Buttons/css/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/ColReorder/css/colReorder.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/DateTime/css/dataTables.dateTime.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/Responsive/css/responsive.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/RowReorder/css/rowReorder.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/Select/css/select.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/StateRestore/css/stateRestore.dataTables.min.css') }}"> --}}

@endsection

@section('content')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Users Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="productsTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 146.2px;">ID</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 226.2px;">Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 104.2px;">Username</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 44.2px;">Role</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 86px;">History</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Edit</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach ($users as $user)
                                        <tr role="row" class="@if($i/2==0) even @else odd @endif">
                                            <td class="sorting_1">{{$user->id}}</td>
                                            <td>{{ucfirst($user->name)}}</td>
                                            <td>{{$user->username}}</td>
                                            <td>{{ucfirst($user->role)}}</td>
                                            <td>
                                                <a href="{{route('user.history', $user->id)}}" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Edit Account">
                                                    <i class="fas fa-history" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{route('users.edit', $user->id)}}" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Edit Account">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button @if ($user->id == Auth::user()->id) @disabled(true) @endif type="submit" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="Delete Account" onclick="return confirm('Are you sure you want to delete this account?');">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">ID</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Username</th>
                                        <th rowspan="1" colspan="1">Role</th>
                                        <th rowspan="1" colspan="1">History</th>
                                        <th rowspan="1" colspan="1">Edit</th>
                                        <th rowspan="1" colspan="1">Delete</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- DataTables Core JavaScript -->
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/datatables.min.js') }}"></script>
    {{-- <!-- Auto Fill -->
    <script type="text/javascript" charset="utf8" src="{{ asset('assets/DataTables/AutoFill/js/autoFill.dataTables.min.js') }}"></script>
    <!-- Buttons -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/DataTables/Buttons/js/buttons.html5.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/DataTables/Buttons/js/buttons.print.min.js') }}"></script>
    <!-- ColReorder -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/ColReorder/js/dataTables.colReorder.min.js') }}"></script>
    <!-- DateTime -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/DateTime/js/dataTables.dateTime.min.js') }}"></script>
    <!-- JSZIP -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/JSZip/jszip.min.js') }}"></script>
    <!-- pdfmake -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/pdfmake/pdfmake.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/DataTables/pdfmake/vfs_fonts.js') }}"></script>
    <!-- Responsive -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <!-- RowReorder -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/RowReorder/js/dataTables.rowReorder.min.js') }}"></script>
    <!-- Select -->
    <script type="text/javascript" src="{{ asset('assets/DataTables/Select/js/dataTables.select.min.js') }}"></script> --}}
    <!--  -->
@endsection

@push('scripts')
    <!-- DataTables Extensions -->

    <script>
        $('#productsTable').DataTable( {
            autoFill: false,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print', 'colvis', 'colReorder'
            ],
            colReorder: true,
            fixedHeader: true,
            // keys: true,
            responsive: true,
            rowGroup: {
                dataSrc: 'group'
            },
            select: true,
        } );
    </script>
@endpush
