@extends('layouts.app')

@section('title', 'Dashboard')

@section('dashboardActive', 'active')

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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('info'))
        <div class="alert alert-info">
            {{ session('info') }}
        </div>
    @endif
    @if (Auth::user()->isAdmin())
        <div class="row">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-primary text-uppercase mb-1">Today's net income</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$stat?->total_income - $stat?->total_cost}} EGP</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-success text-uppercase mb-1">Earnings (Daily)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$stat?->total_income ?? 0}} EGP</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-info text-uppercase mb-1">Earnings (Weekly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$weeklyStat ?? 0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-s font-weight-bold text-warning text-uppercase mb-1">Earnings (Monthly)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$monthlyStat ?? 0}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products Table</h6>
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
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 104.2px;">Stock</th>
                                        @if (Auth::user()->isAdmin())
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 44.2px;">Sold</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 96.2px;">Cost</th>
                                        @endif
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Price</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Add to cart</th>
                                        @if (Auth::user()->isAdmin())
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Edit</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 86px;">Delete</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; @endphp
                                    @foreach ($products as $product)
                                        <tr role="row" class="@if($i/2==0) even @else odd @endif">
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->name}}</td>
                                            <td>{{$product->quantity}}</td>
                                            @if (Auth::user()->isAdmin())
                                                <td>{{$product->total_sales}}</td>
                                                <td>{{number_format($product->cost, 2)}}</td>
                                            @endif
                                            <td>{{number_format($product->price, 2)}}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary add-to-cart" data-placement="bottom" title="Add to cart" data-toggle="modal" data-target="#exampleModalCenter" data-stock="{{$product->quantity ?? 1}}" data-id ="{{$product->id}}" @if ($product->quantity == 0) disabled @endif>
                                                    <i class="fas fa-tag"></i>
                                                </button>
                                            </td>
                                            @if (Auth::user()->isAdmin())
                                                <td>
                                                    <a href="{{route('products.edit', $product->id)}}" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Edit Product">
                                                        <i class="fas fa-pen"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="Send to trash" onclick="return confirm('Are you sure you want to delete this product?');">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            @endif
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">ID</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Stock</th>
                                        @if (Auth::user()->isAdmin())
                                        <th rowspan="1" colspan="1">Sold</th>
                                            <th rowspan="1" colspan="1">Cost</th>
                                        @endif
                                        <th rowspan="1" colspan="1">Price</th>
                                        <th>Add to cart</th>
                                        @if (Auth::user()->isAdmin())
                                            <th rowspan="1" colspan="1">Edit</th>
                                            <th rowspan="1" colspan="1">Delete</th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#productsTable').on('click', '.add-to-cart', function() {
                const productId = $(this).attr('data-id');
                const maxStock = $(this).attr('data-stock');
                // Reset the input value
                $('#quantity-input').val(1);
                // Set the maximum input value for the quantity input field
                $('#quantity-input').attr('max', maxStock);
                $('#hidden-product-id').attr('value', productId);
            });
            $('#cart-submit-button').click(function() {
                $('#add-to-cart-form').submit();
            });
        });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="quantityModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quantityModal">Enter Quantity</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('add.cart')}}" method="post" id="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="id" id="hidden-product-id" value="">
                        <div class="form-outline" style="width: 22rem;">
                            {{-- <label class="form-label" for="typeNumber">Number input</label> --}}
                            <input min="1" max="" type="number" id="quantity-input" name="quantity" class="form-control"/>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="cart-submit-button">Add To Cart</button>
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
            // colReorder: true,
            fixedHeader: true,
            // keys: true,
            responsive: true,
            rowGroup: {
                dataSrc: 'group'
            },
            select: true,
            paging: true,
            // scrollY: 500,
        } );

    </script>
@endpush
