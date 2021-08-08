@extends('layouts.main')
@section('title') Tambah Master Supplier @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Master Supplier</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-shipping-fast"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Supplier</a></li>
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
    <div class="col-12 col-lg-8 card ">
        <div class="card-header">
            <h4 class="card-title">Edit Supplier</h4>
        </div>
        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST">
            @method('PUT')
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
                <div class="form-group @error('kd_supp') has-error has-feedback @enderror">
                    <label>Kode Supplier</label>
                    <input name="kd_supp" value="{{ old('kd_supp') ?? $supplier->kd_supp }}" type="text" class="form-control form-control-alternative" placeholder="Kode Supplier">
                    @error('kd_supp') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('nama') has-error has-feedback @enderror">
                    <label>Nama</label>
                    <input name="nama" value="{{ old('nama') ?? $supplier->nama }}" type="text" class="form-control form-control-alternative" placeholder="Nama">
                    @error('nama') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('telpon') has-error has-feedback @enderror">
                    <label>Telpon</label>
                    <input name="telpon" value="{{ old('telpon') ?? $supplier->telpon }}" type="text" class="form-control form-control-alternative" placeholder="Telpon">
                    @error('telpon') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('email') has-error has-feedback @enderror">
                    <label>Telpon</label>
                    <input name="email" value="{{ old('email') ?? $supplier->email }}" type="email" class="form-control form-control-alternative" placeholder="Email">
                    @error('email') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('alamat') has-error has-feedback @enderror">
                    <label>Alamat</label>
                    <input name="alamat" value="{{ old('alamat') ?? $supplier->alamat }}" type="text" class="form-control form-control-alternative" placeholder="Alamat">
                    @error('alamat') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a class="btn btn-danger mr-2" href="{{ route('supplier.index') }}">
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
