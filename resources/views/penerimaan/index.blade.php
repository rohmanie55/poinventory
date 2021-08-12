@extends('layouts.main')

@section('title')
Transaksi Penerimaan
@endsection

@section('header')
 <div class="header-body">
    <div class="row align-items-center py-4">
      <div class="col-lg-6 col-7">
        <h6 class="h2 text-white d-inline-block mb-0">Transaksi Penerimaan</h6>
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
          <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
            <li class="breadcrumb-item text-white"><i class="fas fa-archive"></i></li>
            <li class="breadcrumb-item"><a href="{{ route('transaction.index') }}">Penerimaan</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-lg-6 col-5 text-right">
        <a href="{{ route('transaction.create') }}" class="btn btn-sm btn-neutral"><i class="fas fa-plus"></i> Tambah</a>
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
                    <td style="width: 5%">#</td>
                    <td style="width: 10%">No Trx</td>
                    <td style="width: 10%">Tgl Trx</td>
                    <th style="width: 10%">Type</th>
                    <th style="width: 20%">User Input</th>
                    <th style="width: 15%">Surat Jalan</th>
                    <th style="width: 15%">Invoice</th>
                    <td style="width: 15%">Option</td>
                </tr>
                </thead>
                <tbody>
                @foreach ($transactions as $idx=>$transaction)
                <tr>
                    <td>{{ $idx+1 }}</td>
                    <td>{{ $transaction->no_trx }}</td>
                    <td>{{ $transaction->tgl_trx }}</td>
                    <td>{{ $transaction->type }}</td>
                    <td>{{ $transaction->user->name }}</td>
                    <td>
                      <a href="{{ asset("storage/trx/sj/$transaction->bukti_sj") }}" target="_blank">{{ $transaction->bukti_sj }}</a>
                    </td>
                    <td>
                       <a href="{{ asset("storage/trx/in/$transaction->bukti_in") }}" target="_blank">{{ $transaction->bukti_in }}</a>
                     </td>
                    <td>
                        <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form 
                        action="{{ route('transaction.destroy', $transaction->id) }}" 
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
@endsection

