@extends('layouts.main')

@section('title')
Master Barang
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Master Barang</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-box"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Barang</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('goods.create') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah</a>
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
            <table id="table" class="display table table-striped table-hover" >
                <thead>
                <tr>
                  <td style="width: 5%">#</td>
                  <td style="width: 10%">Kode</td>
                  <td style="width: 30%">Nama Barang</td>
                  <td style="width: 15%">Harga</td>
                  <td style="width: 10%">Stok Awal</td>
                  <td style="width: 20%">Satuan</td>
                  <td style="width: 15%;">Option</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($goods as $idx=>$good)
                <tr>
                  <td>{{ $idx+1 }}</td>
                  <td>{{ $good->kd_brg }}</td>
                  <td>{{ $good->nm_brg }}</td>
                  <td>@currency($good->harga)</td>
                  <td>{{ $good->stock }}</td>
                  <td>{{ $good->unit }}</td>
                  <td>
                      <a href="{{ route('goods.edit', $good->id) }}" class="btn btn-sm btn-info">
                          <i class="fas fa-edit"></i>
                      </a>
                      <form 
                      action="{{ route('goods.destroy', $good->id) }}" 
                      method="POST"
                      style="display: inline"
                      onsubmit="return confirm('Are you sure to delete this data?')">
                          @csrf
                          @method('DELETE')
                          <button class="btn btn-sm btn-danger"> <i class="fas fa-trash"></i></button>
                      </form>
                  </td>
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
          scrollY:        true,
          scrollX:        true,
          scrollCollapse: true,
          fixedColumns:   {
            rightColumns: 1,
            leftColumns: 0
          }
        });
    });
</script>
@endsection

