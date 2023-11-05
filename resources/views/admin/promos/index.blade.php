@extends('layouts.app')

@section('title', 'Create Promocode')

@section('mngpromoActive', 'active')

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
            <h6 class="m-0 font-weight-bold text-primary">Promocodes Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="productsTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 226.2px;">Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 104.2px;">discount</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 44.2px;">Used</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Created At</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Edit</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach ($promocodes as $promocode)
                                        <tr role="row" class="@if($i/2==0) even @else odd @endif">
                                            <td>{{ucfirst($promocode->code)}}</td>
                                            <td>{{$promocode->discount . '%'}}</td>
                                            <td>{{$promocode->is_used ? 'YES' : 'NO'}}</td>
                                            <td>{{$promocode->created_at?->diffForHumans()}}</td>
                                            <td>
                                                <a href="{{route('promos.edit', $promocode->id)}}" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Edit Promocade">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{ route('promos.destroy', $promocode->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="Delete Promocade" onclick="return confirm('Are you sure you want to delete this promocode?');">
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
                                        <th rowspan="1" colspan="1">Code</th>
                                        <th rowspan="1" colspan="1">Discount</th>
                                        <th rowspan="1" colspan="1">Used</th>
                                        <th rowspan="1" colspan="1">Created At</th>
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

