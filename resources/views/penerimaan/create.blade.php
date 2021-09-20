@extends('layouts.main')
@section('title') Tambah Penerimaan @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Penerimaan</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-archive"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}">Penerimaan</a></li>
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
            <h4 class="card-title">Tambah Penerimaan</h4>
        </div>
        <form action="{{ route('transaction.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
            <div class="form-group @error('no_trx') has-error has-feedback @enderror">
                <label>No Order</label>
                <input name="no_trx" value="{{ old('no_trx') }}" type="text" class="form-control form-control-alternative" placeholder="No Order" required>
                @error('no_trx') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            <div class="form-group @error('tgl_trx') has-error has-feedback @enderror">
                <label>Tgl Transaksi</label>
                <input name="tgl_trx" value="{{ old('tgl_trx') }}" type="date" class="form-control form-control-alternative">
                @error('tgl_trx') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>

            <div class="form-group @error('bukti_sj') has-error has-feedback @enderror">
                <label>Surat Jalan</label>
                <input name="bukti_sj" value="{{ old('bukti_sj') }}" type="file" class="form-control form-control-alternative">
                @error('bukti_sj') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>

            <div class="form-group @error('bukti_in') has-error has-feedback @enderror">
                <label>Surat Invoice</label>
                <input name="bukti_in" value="{{ old('bukti_in') }}" type="file" class="form-control form-control-alternative">
                @error('bukti_in') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>

            <div class="form-group @error('type') has-error has-feedback @enderror">
                <label>Jenis Transaksi</label>
                <select name="type" class="form-control form-control-alternative">
                    <option value="received" {{ old('type')=='received' ? 'selected' : ''}}>Diterima</option>
                    <option value="returned" {{ old('type')=='returned' ? 'selected' : ''}}>Diretur</option>
                </select>
                @error('type') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>

            <div class="form-group @error('order_id') has-error has-feedback @enderror">
                <label>Pilih Order</label>
                <select name="order_id" id="order_id" class="form-control select2" onchange="loadOrder()">
                    @foreach ($orders->where('detaile', '<>', null) as $order)
                        <option value="{{ $order->id }}">{{ $order->no_order }} | {{ $order->supplier->nama }}</option>
                    @endforeach
                </select>
                @error('order_id') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>
            </div>

            <div class="col-12 row pt-4" id="barang_field">

            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a class="btn btn-danger mr-2" href="{{ route('transaction.index') }}">
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

@section('script')
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    const orders= {!! json_encode($orders->toArray(), JSON_HEX_TAG) !!}

    loadOrder = ()=>{
        const req_id  = $("#order_id").val() || orders[0].id

        const kanban = orders.find(req=>req.id==req_id)

        $('#barang_field').empty();
        kanban.detaile.forEach((detail, idx) => addField(detail, idx));
    }

    addField = (detail, idx) =>{
    const field = `
    <div class="form-group col-7">
        <label>Nama Barang</label>
        <input type="hidden" name="detail_id[]" value="${detail.id}">
        <input type="hidden" name="barang_id[]" value="${detail.b_id}">
        <input type="hidden" name="kanban_det_id[]" value="${detail.kanban_det_id}">
        <input name='barang[]' class="form-control form-control-alternative" value="${detail.kd_brg} - ${detail.nm_brg}" readonly>
    </div>
    <div class="form-group col-2">
        <label>Qty</label>
        <input name="qty_order[]" required min="0" max="${detail.qty_sisa}" type="number" class="form-control form-control-alternative" value="${detail.qty_sisa}" placeholder="Qty">
    </div>
    <div class="form-group col-3">
        <label>Catatan</label>
        <input type="text" class="form-control form-control-alternative" name="note[]">
    </div>
    `
    $('#barang_field').append(field)
}

loadOrder();
</script>
@endsection