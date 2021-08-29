@extends('layouts.main')

@section('title')
Laporan Kanban
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Laporan Kanban</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-box"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('report.kanban') }}">Terbaru</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('report.kanban', ['print'=>true]) }}" class="btn btn-sm btn-neutral" target="_blank"><i class="fas fa-print"></i> Cetak</a>
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
                  <td style="width: 10%">No Request</td>
                  <td style="width: 10%">Tgl Request</td>
                  <td style="width: 15%">Nama Barang</td>
                  <td style="width: 10%">Jumlah</td>
                  <td style="width: 10%">Status</td>
                  <td style="width: 30%">Tujuan</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($kanbans as $idx=>$kanban)
                <tr>
                  <td>{{ $idx+1 }}</td>
                  <td>{{ $kanban->kanban->no_request }}</td>
                  <td>{{ $kanban->kanban->tgl_request }}</td>
                  <td>{{ $kanban->barang->kd_brg." - ".$kanban->barang->nm_brg }}</td>
                  <td>{{ $kanban->qty_request }} {{ $kanban->barang->unit }}</td>
                  <td>{{ $kanban->status }}</td>
                  <td>{{ $kanban->kanban->tujuan }}</td>
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

