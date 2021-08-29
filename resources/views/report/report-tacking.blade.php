@extends('layouts.main')

@section('title')
Laporan Pengiriman
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Laporan Pengiriman</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-box"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('report.tacking') }}">Terbaru</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('report.tacking', ['print'=>true]) }}" class="btn btn-sm btn-neutral" target="_blank"><i class="fas fa-print"></i> Cetak</a>
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="row">
    <!-- Light table -->
    <div class="col">
      <div class="card">
        <!-- Light table -->
        <div class="card-header">
          <form action="" class="form-inline float-right">
            <div class="form-group">
              <input type="date" name="start" value="{{ $start }}" class="form-control-sm">
            </div>
            <div class="form-group">
            <input type="date" name="end" value="{{ $end }}" class="form-control-sm">
            </div>
            <button class="btn btn-sm btn-dark"><i class="fas fa-search"></i></button>
          </form>
        </div>
        <div class="table-responsive py-4">
            <table id="table" class="display table table-striped" >
                <thead>
                <tr>
                  <td style="width: 5%">#</td>
                  <td style="width: 10%">No Pengiriman</td>
                  <td style="width: 10%">Tgl</td>
                  <td style="width: 10%">Lokasi</td>
                  <td style="width: 10%">Penerima</td>
                  <td style="width: 25%">Nama Barang</td>
                  <td style="width: 10%">Jumlah</td>
                  <td style="width: 20%">Tujuan</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($tackingouts as $idx=>$tackingout)
                <tr>
                  <td>{{ $idx+1 }}</td>
                  <td>{{ $tackingout->tackingout->no_tacking }}</td>
                  <td>{{ $tackingout->tackingout->tgl_tacking }}</td>
                  <td>{{ $tackingout->tackingout->lokasi }}</td>
                  <td>{{ $tackingout->tackingout->receiveby }}</td>
                  <td>{{ $tackingout->barang->kd_brg." - ".$tackingout->barang->nm_brg }}</td>
                  <td>{{ $tackingout->qty_brg }} {{ $tackingout->barang->unit }}</td>
                  <td>{{ $tackingout->tackingout->tujuan }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script >
    $(document).ready(function() {
        $('#table').DataTable({
        });
    });
</script>
@endsection

