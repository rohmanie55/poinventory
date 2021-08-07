@extends('layouts.main')

@section('title')
Dashboard
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Master User</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-user"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('user.create') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah</a>
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
                    <td>Nama</td>
                    <td>Username</td>
                    <th>Email</th>
                    <td>Role</td>
                    <td style="width: 15%;">Option</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $idx=>$user)
                <tr>
                    <td>{{ $idx+1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('user.edit', ['user'=>$user->id]) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form 
                        action="{{ route('user.destroy', ['user'=>$user->id]) }}" 
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
        });
    });
</script>
@endsection

