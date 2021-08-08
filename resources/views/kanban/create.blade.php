@extends('layouts.main')
@section('title') Tambah Kanban @endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Kanban</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-paper-plane"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('kanban.index') }}">Kanban</a></li>
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
            <h4 class="card-title">Tambah Kanban</h4>
        </div>
        <form action="{{ route('kanban.store') }}" method="POST">
            @csrf
        <div class="card-body p-4 row justify-content-center bg-secondary">
            <div class="col-12">
                <div class="form-group @error('tgl_request') has-error has-feedback @enderror">
                    <label>Tgl Request</label>
                    <input name="tgl_request" value="{{ old('tgl_request') }}" type="date" class="form-control form-control-alternative" placeholder="Tgl Request" required>
                    @error('tgl_request') 
                    <small class="form-text text-danger">
                        <strong>{{ $message }}</strong>
                    </small> 
                    @enderror
                </div>
                <div class="form-group @error('tgl_butuh') has-error has-feedback @enderror">
                    <label>Tgl Butuh</label>
                    <input name="tgl_butuh" value="{{ old('tgl_butuh') }}" type="date" class="form-control form-control-alternative" placeholder="Tgl Butuh" required>
                    @error('tgl_butuh') 
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
                        <select name="barang_id[]" class="form-control select2">
                            @foreach ($goods as $good)
                            <option value="{{ $good->id }}">{{ $good->kd_brg }} - {{ $good->nm_brg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group qty col-3">
                        <label>Qty</label>
                        <input name="qty_request[]" min="0" value="{{ old('qty_request') }}" type="number" class="form-control form-control-alternative" placeholder="Qty" required>
                    </div>
                    <div class="col-1 action">
                        <label>&nbsp;</label>
                        <button type="button" onclick="removeField(0)" class="btn btn-sm btn-danger pull-right mt-3"> <i class="fas fa-trash"></i></button>
                    </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <a class="btn btn-danger mr-2" href="{{ route('kanban.index') }}">
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
        goods.forEach(kanban=> options +=`<option value="${kanban.id}">${kanban.kd_brg} - ${kanban.nm_brg}</option>`)
        const field = `
        <div class="form-group col-8 barang">
            <label>Nama Barang</label>
            <select name="barang_id[]" class="form-control form-control-alternative select2">
            ${options}
            </select>
        </div>
        <div class="form-group col-3 qty">
            <label>Qty</label>
            <input name="qty_request[]" min="0" required type="number" class="form-control form-control-alternative" placeholder="Qty">
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
