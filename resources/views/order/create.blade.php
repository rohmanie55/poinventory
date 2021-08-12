@extends('layouts.main')
@section('title') Tambah Order @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Order</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-shopping-bag"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">Order</a></li>
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
            <h4 class="card-title">Tambah Order</h4>
        </div>
        <form action="{{ route('order.store') }}" method="POST">
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">

                <div class="form-group @error('tgl_order') has-error has-feedback @enderror">
                    <label>Tgl Order</label>
                    <input name="tgl_order" value="{{ old('tgl_order') }}" type="date" class="form-control form-control-alternative" placeholder="Tgl Order" required>
                    @error('tgl_order') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('suplier_id') has-error has-feedback @enderror">
                    <label>Pilih Supplier</label>
                    <select name="supplier_id" class="form-control form-control-alternative select2" required>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{ $supplier->id==old('supplier_id') ? 'selected' : ''}}>{{ $supplier->kd_supp }} - {{ $supplier->nama }}</option>
                        @endforeach
                    </select>
                    @error('suplier_id') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('kanban_id') has-error has-feedback @enderror">
                    <label>Pilih Kanban</label>
                    <select id="kanban_id" name="kanban_id" class="form-control form-control-alternative select2" onchange="loadKanban()" required>
                        @foreach ($kanbans->where('detaile', '<>', null) as $kanban)
                        <option value="{{ $kanban->id }}" {{ $kanban->id==$kanban_id ? 'selected' : ''}}>{{ $kanban->no_request }} | {{ $kanban->tujuan}} - by {{ $kanban->user->name }}</option>
                        @endforeach
                    </select>
                    @error('kanban_id') 
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
            <a class="btn btn-danger mr-2" href="{{ route('order.index') }}">
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

        const kanbans= {!! json_encode($kanbans->toArray(), JSON_HEX_TAG) !!}

        loadKanban = ()=>{
            const req_id  = $("#kanban_id").val() || kanbans[0].id

            const kanban = kanbans.find(req=>req.id==req_id)

            $('#barang_field').empty();
            kanban.detaile.forEach((detail, idx) => addField(detail, idx));

            getTotal()
        }

        addField = (detail, idx) =>{
        const field = `
        <div class="form-group col-7">
            <label>Nama Barang</label>
            <input type="hidden" name="detail_id[]" value="${detail.id}">
            <input type="hidden" name="barang_id[]" value="${detail.b_id}">
            <input type="hidden" name="harga[]" value="${detail.harga}">
            <input name='barang[]' class="form-control form-control-alternative" value="${detail.kd_brg} - ${detail.nm_brg} @ ${convertToRupiah(detail.harga)}" readonly>
        </div>
        <div class="form-group col-2">
            <label>Qty</label>
            <input name="qty_order[]" onchange="sumTotal(${idx})" required min="0" max="${detail.qty_sisa}" type="number" class="form-control form-control-alternative" value="${detail.qty_sisa}" placeholder="Qty">
        </div>
        <div class="form-group col-3">
            <label>Subtotal</label>
            <input type="number" class="form-control form-control-alternative" readonly name="subtotal[]" value="${detail.qty_sisa*detail.harga}">
        </div>
        `
        $('#barang_field').append(field)
    }

    sumTotal=(idx) =>{
        $("input[name='subtotal[]']")[idx].value =  $("input[name='qty_order[]']")[idx].value*$("input[name='harga[]']")[idx].value
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

    loadKanban();
    </script>
@endsection