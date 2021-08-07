@extends('layouts.main')
@section('title') Tambah Master Barang @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Master Barang</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-box"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Barang</a></li>
            <li class="breadcrumb-item"><a href="#">Edit</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        
      </div>
    </div>
  </div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-8 card ">
        <div class="card-header">
            <h4 class="card-title">Edit Barang</h4>
        </div>
        <form action="{{ route('goods.update', $goods->id) }}" method="POST">
            @method('PUT')
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
                <div class="form-group @error('kd_brg') has-error has-feedback @enderror">
                    <label>Kode Barang</label>
                    <input name="kd_brg" value="{{ old('kd_brg') ?? $goods->kd_brg }}" type="text" class="form-control" placeholder="Kode Barang">
                    @error('kd_brg') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('nm_brg') has-error has-feedback @enderror">
                    <label>Nama</label>
                    <input name="nm_brg" value="{{ old('nm_brg') ?? $goods->nm_brg }}" type="text" class="form-control" placeholder="Nama">
                    @error('nm_brg') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('unit') has-error has-feedback @enderror">
                    <label>Unit</label>
                    <input name="unit" value="{{ old('unit') ?? $goods->unit }}" type="text" class="form-control" placeholder="Unit (PCS, SET)">
                    @error('unit') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('harga') has-error has-feedback @enderror">
                    <label>Harga</label>
                    <input name="harga" value="{{ old('harga') ?? $goods->harga }}" type="text" class="form-control" placeholder="Harga">
                    @error('harga') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('stock') has-error has-feedback @enderror">
                    <label>Stock</label>
                    <input name="stock" value="{{ old('stock') ?? $goods->stock }}" type="number" class="form-control" placeholder="Stock">
                    @error('stock') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a class="btn btn-danger mr-2" href="{{ route('goods.index') }}">
                <i class="fas fa-times"></i> Batal
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </div>
        </form>
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
