@extends('layouts.main')
@section('title') Tambah Master User @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Master User</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-user"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item"><a href="#">Tambah</a></li>
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
            <h4 class="card-title">Tambah User</h4>
        </div>
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
            <div class="form-group @error('name') has-error has-feedback @enderror">
                <label>Nama</label>
                <input name="name" value="{{ old('name') }}" type="text" class="form-control form-control-alternative" placeholder="Nama">
                @error('name') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            <div class="form-group @error('email') has-error has-feedback @enderror">
                <label>Email</label>
                <input name="email" value="{{ old('email') }}" type="email" class="form-control form-control-alternative" placeholder="Email">
                @error('email') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            <div class="form-group @error('username') has-error has-feedback @enderror">
                <label>Username</label>
                <input name="username" value="{{ old('username') }}" type="text" class="form-control form-control-alternative" placeholder="Username">
                @error('username') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            <div class="form-group @error('password') has-error has-feedback @enderror">
                <label>Password</label>
                <input name="password" value="{{ old('password') }}" type="text" class="form-control form-control-alternative" placeholder="Password">
                @error('password') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            <div class="form-group @error('role') has-error has-feedback @enderror">
                <label>Role</label>
                <select name="role" class="form-control form-control-alternative">
                    <option {{ old('role')=='admin' ? 'selected' : ''}}>admin</option>
                    <option {{ old('role')=='gudang' ? 'selected' : ''}}>gudang</option>
                    <option {{ old('role')=='purchasing' ? 'selected' : ''}}>purchasing</option>
                    <option {{ old('role')=='finance' ? 'selected' : ''}}>finance</option>
                    <option {{ old('role')=='manager' ? 'selected' : ''}}>manager</option>
                </select>
                @error('role') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a class="btn btn-danger mr-2" href="{{ route('user.index') }}">
                <i class="fas fa-times"></i> Batal
            </a>
            <button class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
        </form>
    </div>
</div>
@endsection