@extends('layouts.main')

@section('title')
Kanban
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Kanban</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-paper-plane"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('kanban.index') }}">Kanban</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('kanban.create') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah</a>
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
                  <th>#</th>
                  <th style="width: 15%;">No Request</th>
                  <th style="width: 20%;">Tgl Request</th>
                  <th style="width: 20%;">Tgl Butuh</th>
                  <th style="width: 25%;">User Request</th>
                  <th style="width: 30%;">Tujuan</th>
                  <th style="width: 20%;">Option</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($kanbans as $idx=>$kanban)
                <tr>
                  <td>{{ $idx+1 }}</td>
                  <td>{{ $kanban->no_request }}</td>
                  <td>{{ $kanban->tgl_request }}</td>
                  <td>{{ $kanban->tgl_butuh }}</td>
                  <td>{{ $kanban->user->name }}</td>
                  <td>{{ $kanban->tujuan }}</td>
                  <td>
                    <button class="btn btn-sm btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail" data-param="{{ json_encode($kanban->details) }}", data-order="{{ json_encode($kanban->order->pluck('no_order')) }}"><i class="fa fa-eye"></i></button>
                      <a href="{{ route('kanban.edit', $kanban->id) }}" class="btn btn-sm btn-info">
                          <i class="fas fa-edit"></i>
                      </a>
                      <form 
                      action="{{ route('kanban.destroy', $kanban->id) }}" 
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

  <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Detail Kanban</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="content-detail">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default  ml-auto" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
@endsection

@section('script')
<script >
    $(document).ready(function() {
        $('#table').DataTable({
          responsive: true,
          scrollY:        true,
          scrollX:        true,
          scrollCollapse: true,
          fixedColumns:   {
            rightColumns: 1,
            leftColumns: 0
          }
        });

        $('.btn-detail').click(function(){
          $("#content-detail").empty()
          let content = `<tr>
          <td>No</td>
          <td>Nama Barang</td>
          <td>Jumlah</td>
          <td>No Order</td>
          <td>Status</td>
          </tr>`
          let details = JSON.parse($(this).attr("data-param"))
          let order   = JSON.parse($(this).attr("data-order"))

          details.forEach((data, num)=>{
            content+=`<tr>
            <td>${num+1}</td>
            <td>${data.barang.kd_brg+' - '+data.barang.nm_brg}</td>
            <td>${data.qty_request} ${data.barang.unit}</td>
            <td>${order}</td>
            <td>${pickStatus(data.status)}</td></tr>`;
          });

          $("#content-detail").append(`<table class="table table-striped">${content}</table>`)
        });
    });
</script>
@endsection

