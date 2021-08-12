@extends('layouts.main')

@section('title')
Laporan Stock Barang
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Laporan Stock Barang</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-box"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('stock') }}">Terbaru</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('stock.print') }}" class="btn btn-sm btn-neutral"><i class="fas fa-print"></i> Cetak</a>
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
        <div class="table-responsive py-4">
            <table id="table" class="display table table-striped" >
                <thead>
                <tr>
                  <td style="width: 5%">#</td>
                  <td style="width: 10%">Kode</td>
                  <td style="width: 30%">Nama Barang</td>
                  <td style="width: 15%">Harga</td>
                  <td style="width: 10%">Stok</td>
                  <td style="width: 20%">Satuan</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($goods as $idx=>$good)
                <tr>
                  <td>{{ $idx+1 }}</td>
                  <td>{{ $good->kd_brg }}</td>
                  <td>{{ $good->nm_brg }}</td>
                  <td>@currency($good->harga)</td>
                  <td>{{ $good->qty_sisa }}</td>
                  <td>{{ $good->unit }}</td>
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

