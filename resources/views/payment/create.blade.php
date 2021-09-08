@extends('layouts.main')
@section('title') Tambah Pembayaran @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Pembayaran</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-archive"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('payment.index') }}">Pembayaran</a></li>
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
            <h4 class="card-title">Tambah Pembayaran</h4>
        </div>
        <form action="{{ route('payment.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
            <div class="form-group @error('tgl_trx') has-error has-feedback @enderror">
                <label>Tgl Transaksi</label>
                <input name="tgl_trx" value="{{ old('tgl_trx') }}" type="date" class="form-control form-control-alternative">
                @error('tgl_trx') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>

            <div class="form-group @error('no_sj') has-error has-feedback @enderror">
                <label>No Surat Jalan</label>
                <input name="no_sj" value="{{ old('no_sj') }}" type="text" class="form-control form-control-alternative">
                @error('no_sj') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>

            <div class="form-group @error('no_inv') has-error has-feedback @enderror">
                <label>No Invoice</label>
                <input name="no_inv" value="{{ old('no_inv') }}" type="text" class="form-control form-control-alternative">
                @error('no_inv') 
                <small class="form-text text-danger">
                    <strong>{{ $message }}</strong>
                </small> 
                @enderror
            </div>


            <div class="form-group @error('trx_id') has-error has-feedback @enderror">
                <label>Pilih Order</label>
                <select name="trx_id" id="trx_id" class="form-control select2" onchange="loadTrx()">
                    @foreach ($transactions->where('detaile', '<>', null) as $trx)
                        <option value="{{ $trx->id }}">{{ $trx->no_trx }} | {{ $trx->tgl_trx }}</option>
                    @endforeach
                </select>
                @error('trx_id') 
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
            <a class="btn btn-danger mr-2" href="{{ route('payment.index') }}">
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

    const trxs= {!! json_encode($transactions->toArray(), JSON_HEX_TAG) !!}

    loadTrx = ()=>{
        const req_id  = $("#trx_id").val() || trxs[0].id

        const trx = trxs.find(req=>req.id==req_id)

        $('#barang_field').empty();
        trx.detaile.forEach((detail, idx) => addField(detail, idx));

        getTotal()
    }

    addField = (detail, idx) =>{
    const field = `
    <div class="form-group col-7">
        <label>Nama Barang</label>
        <input type="hidden" name="detail_id[]" value="${detail.id}">
        <input type="hidden" name="barang_id[]" value="${detail.b_id}">
        <input type="hidden" name="harga[]" value="${detail.harga}">
        <input name='barang[]' class="form-control form-control-alternative" value="${detail.kd_brg} - ${detail.nm_brg}" readonly>
    </div>
    <div class="form-group col-2">
        <label>Qty</label>
        <input name="qty_brg[]" required min="0" max="${detail.qty_sisa}" onchange="sumTotal(${idx})" type="number" class="form-control form-control-alternative" value="${detail.qty_sisa}" placeholder="Qty">
    </div>
    <div class="form-group col-3">
            <label>Subtotal</label>
            <input type="number" class="form-control form-control-alternative" readonly name="subtotal[]" value="${detail.qty_sisa*detail.harga}">
    </div>
    `
    $('#barang_field').append(field)
}

   sumTotal=(idx) =>{
        $("input[name='subtotal[]']")[idx].value =  $("input[name='qty_brg[]']")[idx].value*$("input[name='harga[]']")[idx].value
        $('.total').remove()
        getTotal()
    }

    getTotal = ()=>{
        let total = 0;
        for (let index = 0; index < $("input[name='subtotal[]']").length; index++) {
            const element = $("input[name='subtotal[]']")[index];
            total += parseFloat(element.value)
        }
        $('#barang_field').append(`<div class="col-9 text-right total"><b>Total:</b></div><div class="col-3 total"><input name="total" type="number" value="${total}" class="form-control form-control-alternative" readonly></div>`)
    }

    loadTrx();
</script>
@endsection