<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    
    <title>
        Admin - @yield('title')
    </title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('assets/admin/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    {{-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> --}}

    <!-- Custom styles for this template-->
    <link href="{{asset('assets/admin/css/sb-admin-2.min.css')}}" rel="stylesheet">

    <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}"></script>

    @yield('css')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"> <strong>مكتبة القبه</strong></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item @yield('dashboardActive')">
                <a class="nav-link" href="{{route('dashboard')}}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
            </li>
            @if (Auth::user()->isAdmin())
                <hr class="sidebar-divider">

                <div class="sidebar-heading">
                    Manage Products
                </div>

                <li class="nav-item @yield('addproductActive')">
                    <a class="nav-link" href="{{route('products.create')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Create Product</span></a>
                </li>

                <hr class="sidebar-divider">

                <div class="sidebar-heading">
                    Promo Codes
                </div>

                <li class="nav-item @yield('cpromoActive')">
                    <a class="nav-link" href="{{route('promos.create')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Create Promocode</span></a>
                </li>

                <li class="nav-item @yield('mngpromoActive')">
                    <a class="nav-link" href="{{route('promos.index')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>View Promocodes</span></a>
                </li>

                <hr class="sidebar-divider">

                <div class="sidebar-heading">
                    Manage Users
                </div>

                <li class="nav-item @yield('usersActive')">
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <i class="fas fa-fw fa-cog"></i>
                        <span>Users</span>
                    </a>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                        <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Manage Accounts:</h6>
                        <a class="collapse-item" href="{{route('users.create')}}">Create User</a>
                        <a class="collapse-item" href="{{route('users.index')}}">View Accounts</a>
                        </div>
                    </div>
                </li>
            @endif
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-search fa-sm"></i>
                                    </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    @if (Auth::user()->isAdmin())
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-2x"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">{{count($AllNotifications) > 5 ? '5+' : (count($AllNotifications) ? count($AllNotifications) : null)}}</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notification Center
                                </h6>
                                @if (!count($AllNotifications))
                                    <h4 class="text-center">No notifications</h4>
                                @endif
                                @foreach ($AllNotifications as $notification)
                                    <form action="{{route('notifications.mark.read', $notification->id)}}" method="post">
                                        @csrf
                                        @if (!$notification->is_read)
                                            <button type="submit" class="dropdown-item d-flex align-items-center" href="#">
                                                <div class="mr-3">
                                                    <div class="icon-circle bg-warning">
                                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="small text-gray-500">{{$notification->created_at->diffForhumans()}}</div>
                                                    Low Stock Alert: {{$notification->message}}
                                                </div>
                                            </button>
                                        @endif
                                    </form>
                                @endforeach
                                <a class="dropdown-item text-center small text-gray-500" href="{{route('notifications.index')}}">Show All Notifications</a>
                            </div>
                        </li>
                    @endif

                    <li class="nav-item dropdown no-arrow mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="cartDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                            <!-- Counter - Alerts -->
                            @php
                                $cart = session()->get('cart', []);
                            @endphp
                            <span class="badge badge-danger badge-counter">{{$cart ? count($cart) : null}}</span>
                        </a>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="cartDropdown">
                            <h6 class="dropdown-header">
                                Cart Center
                            </h6>
                            <div id="cart-container">
                                @if (!$cart)
                                    <h4 class="text-center">Cart is empty</h4>
                                @endif
                                @foreach ($cart as $key => $product)
                                    <span class="dropdown-item d-flex align-items-center w-100">
                                        <form action="{{route('remove.item.from.cart')}}" method="POST" class="mr-3">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$product['id']}}">
                                            <button class="icon-circle" style="background-color:#e74a3b;">
                                                <i class="fas fa-times fa-2x text-white"></i>
                                            </button>
                                        </form>
                                        <div class="w-100">
                                            <div class="d-flex justify-content-between">
                                                <span class="font-weight-bold">{{$product['name']}} {{$product['quantity'] > 1 ? '(' . $product['quantity'] . ')' : null}}</span>
                                            </div>
                                            <div class="d-flex w-100 justify-content-between">
                                                <div class="small text-gray-800">{{$product['id']}}</div>
                                                <div class="small text-gray-700 font-weight-bold text-lg">{{$product['price']}}</div>
                                            </div>
                                        </div>
                                    </span>
                                @endforeach
                            </div>
                            @if ($cart)
                                <a class="dropdown-item text-center small text-gray-500" href="{{route('cart')}}" id="gotocart">Checkout</a>
                            @endif
                        </div>
                    </li>

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{Auth::user()->name}}</span>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{route('users.edit', Auth::user()->id)}}">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                            </a>
                        </div>
                    </li>
                </ul>
                </nav>
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; مكتبة القبه 2023</span>
                </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <form class="modal-footer" method="POST" action="{{route('logout.submit')}}">
                    @csrf
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->

    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets/admin/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    {{-- <script src="{{ asset('assets/admin/vendor/chart.js/Chart.min.js') }}"></script> --}}

    <!-- Page level custom scripts -->
    {{-- <script src="{{ asset('assets/admin/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/admin/js/demo/chart-pie-demo.js') }}"></script> --}}

    @yield('js')

    @stack('scripts')
</body>
</html>
