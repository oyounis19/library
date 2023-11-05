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
            <h6 class="m-0 font-weight-bold text-primary">Sales history Table</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="salesTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" aria-sort="ascending" style="width: 146.2px;">Transaction Date</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" style="width: 104.2px;">Total Amount</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" style="width: 104.2px;">Promo Code</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" style="width: 44.2px;">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach ($sales as $sale)
                                        <tr role="row" class="@if($i/2==0) even @else odd @endif">
                                            <td class="sorting_1">{{$sale->created_at}}</td>
                                            <td>{{$sale->total_price}}</td>
                                            <td>
                                                @if ($sale->promo_applied == 1)
                                                    {{(int)$sale->discount_percentage . '%'}}
                                                @else
                                                    None
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-primary info" data-placement="bottom" title="See Details" data-toggle="modal" data-target="#DetailsModal" data-sale-id="{{$sale->id}}">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th >Transaction Date</th>
                                        <th >Total Amount</th>
                                        <th >Promo Code</th>
                                        <th >Details</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="DetailsModal" tabindex="-1" role="dialog" aria-labelledby="quantityModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quantityModal">Transaction Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered dataTable" id="salesItemsTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                        <thead>
                            <tr role="row">
                                <th class="sorting" tabindex="0" aria-controls="dataTable"  aria-sort="ascending" style="width: 146.2px;">Product ID</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable"  style="width: 104.2px;">Quantity</th>
                                <th class="sorting" tabindex="0" aria-controls="dataTable"  style="width: 104.2px;">SubTotal</th>
                            </tr>
                        </thead>
                        <script>
                            var saleId = 0;
                            $(document).ready(function() {
                                $('#salesTable').on('click', '.info', function() {
                                    saleId = $(this).attr('data-sale-id');
                                });
                            });
                        </script>
                        <tbody id="saleItemsTableBody">
                        </tbody>
                        <tfoot>
                            <tr>
                                <th >Product ID</th>
                                <th >Quantity</th>
                                <th >SubTotal</th>
                            </tr>
                        </tfoot>
                            <script>
                                var saleItems = @json($saleItems);

                                $(document).ready(function() {
                                    $('#salesTable').on('click', '.info', function() {
                                        var saleId = $(this).data('sale-id');
                                        populateSaleItemsTable(saleId);
                                    });
                                });

                                function populateSaleItemsTable(saleId) {
                                    var saleItemsTableBody = $('#saleItemsTableBody');
                                    saleItemsTableBody.empty(); // Clear the table body first

                                    saleItems.forEach(function(item) {
                                        if (item.sale_id == saleId) {
                                            saleItemsTableBody.append(
                                                `<tr>
                                                    <td>${item.id}</td>
                                                    <td>${item.quantity}</td>
                                                    <td>${item.total_price}</td>
                                                    <!-- Add more columns for other item details -->
                                                </tr>`
                                            );
                                        }
                                    });
                                }
                            </script>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Dismiss</button>
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
        $('#salesTable').DataTable( {
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
        // $('#salesItemsTable').DataTable( {
        //     autoFill: false,
        //     dom: 'Bfrtip',
        //     buttons: [
        //         'copy', 'excel', 'pdf', 'print',
        //     ],
        //     colReorder: true,
        //     fixedHeader: true,
        //     // keys: true,
        //     responsive: true,
        //     rowGroup: {
        //         dataSrc: 'group'
        //     },
        //     select: true,
        //     search:false,
        // } );
    </script>
@endpush
