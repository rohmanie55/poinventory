<!DOCTYPE html>
<html>
<head>
	<title>Laporan Kanban Terbaru</title>
</head>
<style type="text/css">
    body{
      margin-top: 3cm;
      margin-left: 2cm;
      margin-right: 2cm;
      margin-bottom: 2cm;
      font-family: Arial, Helvetica, sans-serif;
      font-size:15px;
    }
    header {
      position: fixed;
      margin-left: 2cm;
      margin-right: 2cm;
      top: 0cm;
      height: 3cm;
    }
    table tr td,
		table tr th{
			padding-top: 5px;
	}

    .collapse{
        border: 1px solid black;
        border-collapse: collapse;
    }
    p{
        text-align:justify;
    }
</style>
<body>
    <header>
        <table>
          <tr>
              <td style="width: 30%">
                  <img src="{{ asset('img/hs.png') }}" style="max-height: 90px">
              </td>
              <td style="width: 70%;padding-left:10px;">
                  <h3>Persedian Kanban </h3>
              </td>
          </tr>
        </table>
        <hr>
      </header>
      <main>
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Kanban Terbaru</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
              <td class="collapse" style="width: 5%">#</td>
              <td class="collapse" style="width: 10%">No Trx</td>
              <td class="collapse" style="width: 10%">Tgl Trx</td>
              <td class="collapse" style="width: 10%">Tipe</td>
              <td class="collapse" style="width: 25%">Nama Barang</td>
              <td class="collapse" style="width: 10%">Jumlah</td>
            </tr>
            @foreach ($trxs as $idx=>$trx)
            <tr class="collapse">
              <td class="collapse">{{ $idx+1 }}</td>
              <td class="collapse">{{ $trx->transaction->no_trx }}</td>
              <td class="collapse">{{ $trx->transaction->tgl_trx }}</td>
              <td class="collapse">{{ $trx->transaction->type }}</td>
              <td class="collapse">{{ $trx->barang->kd_brg." - ".$trx->barang->nm_brg }}</td>
              <td class="collapse">{{ $trx->qty_brg }} {{ $trx->barang->unit }}</td>
            </tr>
            @endforeach
        </table>
      </main>
</body>