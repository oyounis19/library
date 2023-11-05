@extends('layouts.app')

@section('title', 'Checkout')

@section('css')
    <!-- DataTables Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/DataTables/datatables.min.css') }}">
@endsection

@section('content')
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
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cart</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="cartTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 104.2px;">ID</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 226.2px;">Name</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 104.2px;">Quantity</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 86px;">Price</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 104.2px;">Subtotal</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 86px;">Edit Quantity</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" style="width: 86px;">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0; $total = 0; $totalQuantity = 0;@endphp
                                    @foreach ($cart as $keys => $product)
                                        <tr role="row" class="@if($i/2==0) even @else odd @endif">
                                            @php
                                                $total += $product['price'] * $product['quantity'];
                                                $totalQuantity += $product['quantity'];
                                            @endphp
                                            <td>{{$product['id']}}</td>
                                            <td>{{$product['name']}}</td>
                                            <td editable>{{$product['quantity']}}</td>
                                            <td>{{$product['price']}}</td>
                                            <td>{{$product['quantity'] * $product['price']}}</td>
                                            <td>
                                                <a href="{{route('edit.quantity', $product['id'])}}" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Edit Quantity">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{route('remove.item.from.cart')}}" method="POST" @style('display:inline')>
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$product['id']}}">
                                                    <button type="submit" class="btn btn-danger btn-circle sell-button" data-toggle="tooltip" data-placement="bottom" title="Remove from cart">
                                                        <i class="fas fa-times fa-2x text-white"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                    <tr>{{-- To be printed by the datatable--}}
                                        <td hidden>999999</td>
                                        <td></td>
                                        <td></td>
                                        <td>{{$totalQuantity}} Items</td>
                                        @php
                                            $oldTotal = null;
                                            if(session('promoDiscount')){
                                                $discountValue = $total * ((int) session('promoDiscount') / 100);
                                                $oldTotal = $total;
                                                $total -= $discountValue;
                                            }
                                            session()->put('total', $total);
                                        @endphp
                                            <td colspan="2" @style('text-align:center;color:black;')>
                                                <h3 @style('display:inline;font-weight:bold;')>Total:
                                                    @if ($oldTotal)
                                                        <s @style('font-weight:lighter;')>{{number_format($oldTotal, 2)}}</s>
                                                    @endif
                                                    {{number_format($total, 2)}}
                                                </h3>
                                            </td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                    <tr>
                                        <th rowspan="1" colspan="1">ID</th>
                                        <th rowspan="1" colspan="1">Name</th>
                                        <th rowspan="1" colspan="1">Quantity</th>
                                        <th rowspan="1" colspan="1">Price</th>
                                        <th rowspan="1" colspan="1">Subtotal</th>
                                        <th rowspan="1" colspan="1">Edit Quantity</th>
                                        <th rowspan="1" colspan="1">Remove</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <br>
                            <hr>
                            <div class="d-flex justify-content-between mt-4">
                                <form action="{{route('apply.promocode')}}" method="post">
                                    @csrf
                                    <input type="text" name="promocode" id="pc" @if (session('promoDiscount')) disabled @endif placeholder=" @if (session('promoDiscount')) Coupon Applied @else Coupon Code @endif">
                                    @error('promocode')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <button type="submit" class="btn btn-primary" @if (session('promoDiscount')) disabled @endif>Apply Coupon</button>
                                </form>

                                <form action="{{route('sell')}}" method="POST" class="btn btn-success btn-icon-split" id="sellForm">
                                    @csrf
                                    <span class="icon text-white-50">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <input type="hidden" name="promoApplied" value="@if($oldTotal) 1 @else 0 @endif">
                                    <span type="submit" class="text" @if (!$cart) onclick="return alert('Cart is empty.');" @else id="sellButton" @endif>Sell</span>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            document.getElementById('sellButton')?.addEventListener('click', function() {
                                                document.getElementById('sellForm').submit();
                                            });
                                        });

                                    </script>
                                </form>
                            </div>
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
@endsection

@push('scripts')
    <script>
        $('#cartTable').DataTable( {
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
                select: false,
            } );
    </script>
@endpush
