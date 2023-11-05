@extends('layouts.app')

@section('title', 'Notifications')

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
            <h6 class="m-0 font-weight-bold text-primary">Notifications</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div id="dataTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered dataTable" id="notTable" width="100%" cellspacing="0" role="grid" aria-describedby="dataTable_info" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1" >Message</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">Is Read</th>
                                        <th class="sorting_desc" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">Issued At</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">Mark As Unread</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTable" rowspan="1" colspan="1">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i=0;@endphp
                                    @foreach ($allNotifications as $notification)
                                        <tr role="row" class="@if($i/2==0) even @else odd @endif">
                                            <td>{{$notification->message}}</td>
                                            <td>{{$notification->is_read ? 'Read' : 'Unread'}}</td>
                                            <td>{{$notification->created_at->diffForHumans()}}</td>
                                            <td>
                                                <form action="{{route('notifications.mark.unread', $notification->id)}}" method="POST" @style('display:inline')>
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$notification->id}}">
                                                    <button type="submit" class="btn btn-warning btn-circle" data-toggle="tooltip" data-placement="bottom" title="Mark As Unread" @if (!$notification->is_read) disabled @endif>
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <form action="{{route('notifications.destroy', $notification->id)}}" method="POST" @style('display:inline')>
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{$notification->id}}">
                                                    <button type="submit" class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="bottom" title="Remove from cart">
                                                        <i class="fas fa-times fa-2x text-white"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @php $i++; @endphp
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="1" colspan="1">Message</th>
                                        <th rowspan="1" colspan="1">Is Read</th>
                                        <th rowspan="1" colspan="1">Issued At</th>
                                        <th rowspan="1" colspan="1">Mark As Unread</th>
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
@endsection

@push('scripts')
    <script>
        $('#notTable').DataTable( {
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
