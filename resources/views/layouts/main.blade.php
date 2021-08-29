<!DOCTYPE html>
<html>
<!--

=========================================================
* Impact Design System - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/impact-design-system
* Copyright 2010 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/impact-design-system/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

-->
<head>
  <meta charset="utf-8">
  <title>Sistem Gudang - @yield('title')</title>

  <!-- Favicon -->
  <link rel="icon" href="{{ asset('img/brand/favicon.png') }}" type="image/png">
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
  <!-- Icons -->
  <link rel="stylesheet" href="{{ asset('vendor/nucleo/css/nucleo.css') }}" type="text/css">
  <link rel="stylesheet" href="{{ asset('vendor/@fortawesome/fontawesome-free/css/all.min.css') }}" type="text/css">
  <!-- Page plugins -->
  {{-- <link rel="stylesheet" href="{{ asset('vendor/fullcalendar/dist/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}"> --}}
  <!-- Argon CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://datatables.net/release-datatables/extensions/FixedColumns/css/fixedColumns.bootstrap4.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" type="text/css">

</head>
<body>
  <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
      <!-- Brand -->
      <div class="sidenav-header  d-flex  align-items-center">
        <a class="navbar-brand" href="{{ route('dashboard') }}">
           <span style="font-size: 12px;"><i class="ni ni-box-2 text-black"></i> <b>PERSEDIAAN  BARANG</b></span>
        </a>
        <div class=" ml-auto ">
          <!-- Sidenav toggler -->
          <div class="sidenav-toggler d-none d-xl-block" data-action="sidenav-unpin" data-target="#sidenav-main">
            <div class="sidenav-toggler-inner">
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
              <i class="sidenav-toggler-line"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <!-- Nav items -->
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link {{ Route::currentRouteName()=='dashboard' ? 'active' : ''}}" href="{{ route('dashboard') }}">
                <i class="ni ni-app text-primary"></i>
                <span class="nav-link-text">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ in_array(Route::currentRouteName(), ['user.index','user.create','user.edit']) ? 'active' : ''}}" href="{{ route('user.index') }}">
                  <i class="ni ni-single-02 text-info"></i>
                  <span class="nav-link-text">Master User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ in_array(Route::currentRouteName(), ['goods.index','goods.create','goods.edit']) ? 'active' : ''}}" href="{{ route('goods.index') }}">
                  <i class="ni ni-box-2 text-orange"></i>
                  <span class="nav-link-text">Master Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ in_array(Route::currentRouteName(), ['supplier.index','supplier.create','supplier.edit']) ? 'active' : ''}}" href="{{ route('supplier.index') }}">
                  <i class="ni ni-delivery-fast text-success"></i>
                  <span class="nav-link-text">Master Supplier</span>
                </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['kanban.index','kanban.create','kanban.edit']) ? 'active' : ''}}" href="{{ route('kanban.index') }}">
                <i class="ni ni-send text-danger"></i>
                <span class="nav-link-text">Kanban</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['order.index','order.create','order.edit']) ? 'active' : ''}}" href="{{ route('order.index') }}">
                <i class="ni ni-bag-17 text-blue"></i>
                <span class="nav-link-text">Order</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['transaction.index','transaction.create','transaction.edit']) ? 'active' : ''}}" href="{{ route('transaction.index') }}">
                <i class="ni ni-archive-2 text-info"></i>
                <span class="nav-link-text">Penerimaan</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['payment.index','payment.create','payment.edit']) ? 'active' : ''}}" href="{{ route('payment.index') }}">
                <i class="ni ni-money-coins text-green"></i>
                <span class="nav-link-text">Pembayaran</span>
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['tackingout.index','tackingout.create','tackingout.edit']) ? 'active' : ''}}" href="{{ route('tackingout.index') }}">
                <i class="ni ni-folder-17 text-default"></i>
                <span class="nav-link-text">Pengiriman</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ in_array(Route::currentRouteName(), ['report.stock','report.kanban','report.order','report.transaction','report.payment','report.tacking']) ? 'active' : ''}}" href="#navbar-tables" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="navbar-tables">
                <i class="ni ni-chart-bar-32 text-danger"></i>
                <span class="nav-link-text">Laporan</span>
              </a>
              <div class="collapse" id="navbar-tables">
                <ul class="nav nav-sm flex-column">
                  <li class="nav-item">
                    <a href="{{ route('report.stock') }}" class="nav-link">
                      <span class="sidenav-mini-icon"><i class="ni ni-archive-2 text-default"></i></span>
                      <span class="sidenav-normal"> Stock Barang </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('report.kanban') }}" class="nav-link">
                      <span class="sidenav-mini-icon"><i class="ni ni-archive-2 text-default"></i></span>
                      <span class="sidenav-normal"> Laporan Kanban </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('report.order') }}" class="nav-link">
                      <span class="sidenav-mini-icon"><i class="ni ni-archive-2 text-default"></i></span>
                      <span class="sidenav-normal"> Laporan Order </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('report.trx') }}" class="nav-link">
                      <span class="sidenav-mini-icon"><i class="ni ni-archive-2 text-default"></i></span>
                      <span class="sidenav-normal"> Laporan Penerimaan </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('report.payment') }}" class="nav-link">
                      <span class="sidenav-mini-icon"><i class="ni ni-archive-2 text-default"></i></span>
                      <span class="sidenav-normal"> Laporan Pembayaran </span>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('report.tacking') }}" class="nav-link">
                      <span class="sidenav-mini-icon"><i class="ni ni-archive-2 text-default"></i></span>
                      <span class="sidenav-normal"> Laporan Pengiriman </span>
                    </a>
                  </li>

                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <!-- Main content -->
  <div class="main-content" id="panel">
    <!-- Topnav -->
    <nav class="navbar navbar-top navbar-expand navbar-dark bg-default border-bottom">
      <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <!-- Navbar links -->
          <ul class="navbar-nav align-items-center  ml-md-auto ">
            <li class="nav-item d-xl-none">
              <!-- Sidenav toggler -->
              <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin" data-target="#sidenav-main">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </div>
            </li>
            <li class="nav-item d-sm-none">
              <a class="nav-link" href="#" data-action="search-show" data-target="#navbar-search-main">
                <i class="ni ni-zoom-split-in"></i>
              </a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="ni ni-bell-55"></i>
                <span class="badge badge-sm badge-circle badge-success border-white" style="position: absolute;top:0">{{ auth()->user()->unreadNotifications->count() }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-xl  dropdown-menu-right  py-0 overflow-hidden">
                <!-- Dropdown header -->
                <div class="px-3 py-3">
                  <h6 class="text-sm text-muted m-0">You have <strong class="text-primary">{{ auth()->user()->unreadNotifications->count() }}</strong> notifications.</h6>
                </div>
                <!-- List group -->
                <div class="list-group list-group-flush">
                  @foreach (auth()->user()->unreadNotifications->take(6) as $notif)
                  <a href="{{ array_key_exists('url', $notif->data) ? $notif->data['url'] : "#" }}" class="list-group-item list-group-item-action">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <!-- Avatar -->
                        <div class="avatar rounded-circle bg-warning">{{ substr($notif->data['title'], 0, 1)}}</div>
                      </div>
                      <div class="col ml--2">
                        <div class="d-flex justify-content-between align-items-center">
                          <div>
                            <h4 class="mb-0 text-sm">{{ $notif->data['title'] }}</h4>
                          </div>
                          <div class="text-right text-muted">
                            <small>{{ $notif->created_at->diffForHumans() }}</small>
                          </div>
                        </div>
                        <p class="text-sm mb-0">{{ $notif->data['body'] }}</p>
                      </div>
                    </div>
                  </a>
                  @endforeach
                </div>
                <!-- View all -->
                <a href="{{ route('notification.index') }}" class="dropdown-item text-center text-primary font-weight-bold py-3">View all</a>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
            <li class="nav-item dropdown">
              <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-center">
                  <span class="avatar avatar-sm rounded-circle bg-info">
                    {{ substr(auth()->user()->name, 0, 1) }}
                  </span>
                  <div class="media-body  ml-2  d-none d-lg-block">
                    <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }}</span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu  dropdown-menu-right ">
                <div class="dropdown-header noti-title">
                  <h6 class="text-overflow m-0">Welcome!</h6>
                </div>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-single-02"></i>
                  <span>My profile</span>
                </a>
                <a href="#!" class="dropdown-item">
                  <i class="ni ni-settings-gear-65"></i>
                  <span>Settings</span>
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}"  style="display: inline">
                  @csrf
                  <button class="dropdown-item" > <i class="ni ni-user-run"></i> Logout</button>
                </form>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Header -->
    <!-- Header -->
    <div class="header bg-default pb-6">
      <div class="container-fluid">
        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="ni ni-check-bold"></i></span>
            <span class="alert-text">{{ session()->get('success') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if(session()->has('fail'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="ni ni-fat-remove"></i></span>
                <span class="alert-text"> {{ session()->get('fail') }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
          @yield('header')
      </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
      @yield('content')
    
      <!-- Footer -->
      <footer class="footer pt-0">
        <div class="row align-items-center justify-content-lg-between">
          <div class="col-lg-6">
            <div class="copyright text-center  text-lg-left  text-muted">
              &copy; 2020 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a> & <a href="https://themesberg.com?ref=creative-tim" class="font-weight-bold ml-1" target="_blank">Themesberg</a>
            </div>
          </div>
          <div class="col-lg-6">
            <ul class="nav nav-footer justify-content-center justify-content-lg-end">
              <li class="nav-item">
                <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
              </li>
              <li class="nav-item">
                <a href="https://themesberg.com" class="nav-link" target="_blank">Themesberg</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
              </li>
              <li class="nav-item">
                <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
              </li>
              <li class="nav-item">
                <a href="https://www.creative-tim.com/license" class="nav-link" target="_blank">License</a>
              </li>
            </ul>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Argon Scripts -->
  <!-- Core -->
  <script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/js-cookie/js.cookie.js') }}"></script>
  <script src="{{ asset('vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
  <script src="{{ asset('vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://datatables.net/release-datatables/extensions/FixedColumns/js/dataTables.fixedColumns.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="{{ asset('js/dashboard.js') }}"></script>
  <script>
    function convertToRupiah(angka){
      var rupiah = '';		
      var angkarev = angka.toString().split('').reverse().join('');
      for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
      return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function pickStatus(status){
      let color = "primary"

      if(status=="ordered")
        color = "info"
      if(status=="received")
        color = "success"
      if(status=="returned")
        color = "danger"
      if(status=="complate")
        color = "default"

      return `<span class="badge badge-${color}">${status}</span>`
    }
</script>
  @yield('script')
</body>

</html>