@extends('layouts.main')

@section('title')
Master Supplier
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Master Supplier</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-shipping-fast"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('supplier.create') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah</a>
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
                  <td>#</td>
                  <td>Kode</td>
                  <td>Nama Suplier</td>
                  <td>Email</td>
                  <td>Telpon</td>
                  <td style="width: 20%;">Alamat</td>
                  <td style="width: 15%;">Option</td>
                </tr>
                </thead>
                <tbody>
                  @foreach ($suppliers as $idx=>$supplier)
                  <tr>
                      <td>{{ $idx+1 }}</td>
                      <td>{{ $supplier->kd_supp }}</td>
                      <td>{{ $supplier->nama }}</td>
                      <td>{{ $supplier->email }}</td>
                      <td>{{ $supplier->telpon }}</td>
                      <td>{{ $supplier->alamat }}</td>
                      <td>
                          <a href="{{ route('supplier.edit', ['supplier'=>$supplier->id]) }}" class="btn btn-sm btn-info">
                              <i class="fas fa-edit"></i>
                          </a>
                          <form 
                          action="{{ route('supplier.destroy', ['supplier'=>$supplier->id]) }}" 
                          method="POST"
                          style="display: inline"
                          onsubmit="return confirm('Are you sure delete this data?')">
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

