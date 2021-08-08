@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('header')
 <div class="header-body">
    <div class="row justify-content-end py-4">
      <div class="col-3">
        <form action="" method="GET" class="form-inline" style="width: 100%;">
          <select name="year" class="form-control-sm form-control-alternative mr-1 col-9">
            @for ($i = 2020; $i <= date('Y'); $i++)
            <option value="{{ $i }}" {{ isset($_GET['year']) && $_GET['year']==$i ? "selected" : ""}} {{ !isset($_GET['year']) && date('Y')==$i ? "selected" : ""  }}>Tahun {{ $i }}</option>
            @endfor
          </select>
          <button type="submit" class="btn btn-sm btn-secondary col-2"> <i class="fa fa-search"></i></button>
        </form>
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="row">
  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Total Barang</h5>
            <span class="h2 font-weight-bold mb-0">{{ $goods }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-orange text-white rounded-circle shadow">
              <i class="ni ni-box-2"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          {{-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
          <span class="text-nowrap">Since last month</span> --}}
        </p>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Total Supplier</h5>
            <span class="h2 font-weight-bold mb-0">{{ $supplier }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow">
              <i class="ni ni-delivery-fast"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          {{-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
          <span class="text-nowrap">Since last month</span> --}}
        </p>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Total Kanban</h5>
            <span class="h2 font-weight-bold mb-0">{{ $kanban }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-red text-white rounded-circle shadow">
              <i class="ni ni-send"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          {{-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
          <span class="text-nowrap">Since last month</span> --}}
        </p>
      </div>
    </div>
  </div>

  <div class="col-xl-3 col-md-6">
    <div class="card card-stats">
      <!-- Card body -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <h5 class="card-title text-uppercase text-muted mb-0">Total Order</h5>
            <span class="h2 font-weight-bold mb-0">{{ $order }}</span>
          </div>
          <div class="col-auto">
            <div class="icon icon-shape bg-gradient-blue text-white rounded-circle shadow">
              <i class="ni ni-bag-17"></i>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-0 text-sm">
          {{-- <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
          <span class="text-nowrap">Since last month</span> --}}
        </p>
      </div>
    </div>
  </div>
</div>
@endsection

