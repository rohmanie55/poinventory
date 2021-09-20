@extends('layouts.main')
@section('title') Tambah Pengiriman @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Pengiriman</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-folder-open"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('tackingout.index') }}">Pengiriman</a></li>
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
            <h4 class="card-title">Tambah Pengiriman</h4>
        </div>
        <form action="{{ route('tackingout.store') }}" method="POST">
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
                <div class="form-group @error('no_tacking') has-error has-feedback @enderror">
                    <label>No Pengiriman</label>
                    <input name="no_tacking" value="{{ old('no_tacking') }}" type="text" class="form-control form-control-alternative" placeholder="No Pengiriman" required>
                    @error('no_tacking') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('tgl_tacking') has-error has-feedback @enderror">
                    <label>Tgl Pengiriman</label>
                    <input name="tgl_tacking" value="{{ old('tgl_tacking') }}" type="date" class="form-control form-control-alternative" placeholder="Tgl Pengiriman" required>
                    @error('tgl_tacking') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('receiveby') has-error has-feedback @enderror">
                    <label>Penerima</label>
                    <input name="receiveby" value="{{ old('receiveby') }}" type="text" class="form-control form-control-alternative" placeholder="Penerima" required>
                    @error('receiveby') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('lokasi') has-error has-feedback @enderror">
                    <label>Lokasi</label>
                    <input name="lokasi" value="{{ old('lokasi') }}" type="text" class="form-control form-control-alternative" placeholder="Lokasi" required>
                    @error('lokasi') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('tujuan') has-error has-feedback @enderror">
                    <label>Tujuan</label>
                    <textarea class="form-control form-control-alternative" name="tujuan"></textarea>
                    @error('tujuan') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
            </div>
            <div class="col-12 row pt-4" id="barang_field">
                <div class="col-9">
                    <h3>Pilih barang :</h3>
                </div>
                <div class="col-3 text-right">
                    <button type="button" onclick="addField()" class="btn btn-sm btn-info pull-right"> <i class="fas fa-plus"></i></button>
                </div>
                <div class="form-group barang col-8">
                    <label>Nama Barang</label>
                    <select name="barang_id[]" class="form-control select2 barang_id">
                        @foreach ($goods as $good)
                        <option value="{{ $good->id }}">{{ $good->kd_brg }} - {{ $good->nm_brg }} ({{ $good->qty_sisa}} {{$good->unit}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group qty col-3">
                    <label>Qty</label>
                    <input name="qty_brg[]"  min="0" value="{{ old('qty_request') }}" type="number" class="form-control form-control-alternative" placeholder="Qty" required>
                </div>
                <div class="col-1 action">
                    <label>&nbsp;</label>
                    <button type="button" onclick="removeField(0)" class="btn btn-sm btn-danger pull-right mt-3"> <i class="fas fa-trash"></i></button>
                </div>
        </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a class="btn btn-danger mr-2" href="{{ route('tackingout.index') }}">
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
<script >
    const goods = {!! json_encode($goods->toArray(), JSON_HEX_TAG) !!}

    addField = () =>{
        let options = ''
        goods.forEach(good=> options +=`<option value="${good.id}">${good.kd_brg} - ${good.nm_brg}(${good.qty_sisa} ${good.unit})</option>`)
        const field = `
        <div class="form-group col-8 barang">
            <label>Nama Barang</label>
            <select name="barang_id[]" class="form-control form-control-alternative select2 barang_id">
            ${options}
            </select>
        </div>
        <div class="form-group col-3 qty">
            <label>Qty</label>
            <input name="qty_brg[]" min="0" required type="number" class="form-control form-control-alternative" placeholder="Qty">
        </div>
        <div class="col-1 action">
            <label>&nbsp;</label>
            <button type="button" onclick="removeField(${$(".barang").length})" class="btn btn-sm btn-danger pull-right mt-3"> <i class="fas fa-trash"></i></button>
        </div>
        `
        $('#barang_field').append(field)

        $('.select2').select2();
    }

    removeField = (idx) =>{
        $( ".barang" )[idx].remove();
        $( ".qty" )[idx].remove();
        $( ".action" )[idx].remove();
    }
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>
@endsection