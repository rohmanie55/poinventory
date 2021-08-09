@extends('layouts.main')

@section('title')
Order
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Order</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-shopping-bag"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('order.create') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah</a>
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
                  <th >#</th>
                  <th style="width: 5%;">No Order</th>
                  <th style="width: 10%;">Tgl Order</th>
                  <th style="width: 20%;">Supplier</th>
                  <th style="width: 15%;">Total</th>
                  <th style="width: 20%;">Approve</th>
                  <th style="width: 25%;">Option</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($orders as $idx=>$order)
                  <tr>
                      <td>{{ $idx+1 }}</td>
                      <td>{{ $order->no_order }}</td>
                      <td>{{ $order->tgl_order }}</td>
                      <td>{{ $order->supplier->kd_supp ?? "" }} - {{ $order->supplier->nama }}</td>
                      <td>@currency($order->total)</td>
                      <td>{{ $order->approve->name ?? '' }} {{ $order->approve_at }}</td>
                      <td>
                        <button class="btn btn-sm btn-primary btn-detail" data-toggle="modal" data-target="#modal-detail" data-param="{{ json_encode($order->details) }}" data-request="{{ json_encode($order->request) }}"><i class="fa fa-eye"></i></button>
                        <a href="{{ route('order.edit', ['order'=>$order->id]) }}" class="btn btn-sm btn-info">
                          <i class="fas fa-edit"></i>
                      </a>
                          @if (is_null($order->approve_at) && in_array(auth()->user()->role, ['manager', 'purchasing']))
                          <form 
                          action="{{ route('order.approve', ['order'=>$order->id]) }}" 
                          method="POST"
                          style="display: inline"
                          onsubmit="return confirm('Are you sure approve this?')">
                              @csrf
                              <button class="btn btn-sm btn-success"> <i class="fas fa-check"></i></button>
                          </form>
                          @endif
                          <form 
                          action="{{ route('order.destroy', ['order'=>$order->id]) }}" 
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

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="modal-title-default">Detail Order</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body table-responsive" id="content-detail">

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

<script>
          $('.btn-detail').click(function(){
          $("#content-detail").empty()
          let content = `
          <tr>
            <td>No</td>
            <td>No Kanban</td>
            <td>Tgl Request</td>
            <td>Tujuan</td>
            <td>Barang</td>
            <td>Qty</td>
            <td>Subtotal</td>
            <td>Status</td>
          </tr>`

          let details = JSON.parse($(this).attr("data-param"))
          let request = JSON.parse($(this).attr("data-request"))

          details.forEach((data, num)=>{
            content+=`
            <tr>
              <td>${num+1}</td>
              <td>${request.no_request}</td>
              <td>${request.tgl_request}</td>
              <td>${request.tujuan}</td>
              <td>${data.barang.kd_brg+' - '+data.barang.nm_brg}</td>
              <td>${data.qty_order} ${data.barang.unit}</td>
              <td>${convertToRupiah(data.subtotal)}</td>
              <td>${pickStatus(data.request.status)}</td>
            </tr>`;
          });

          $("#content-detail").append(`<table class="table table-striped">${content}</table>`)
        });
</script>
@endsection

