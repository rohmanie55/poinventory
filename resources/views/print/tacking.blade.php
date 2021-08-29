<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pengiriman Terbaru</title>
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
                  <h3>Persedian Barang </h3>
              </td>
          </tr>
        </table>
        <hr>
      </header>
      <main>
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Pengiriman Terbaru</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
              <td class="collapse" style="width: 5%">#</td>
              <td class="collapse" style="width: 10%">No Pengiriman</td>
              <td class="collapse" style="width: 10%">Tgl</td>
              <td class="collapse" style="width: 10%">Lokasi</td>
              <td class="collapse" style="width: 10%">Penerima</td>
              <td class="collapse" style="width: 25%">Nama Barang</td>
              <td class="collapse" style="width: 10%">Jumlah</td>
              <td class="collapse" style="width: 20%">Tujuan</td>
            </tr>
            @foreach ($tackingouts as $idx=>$tackingout)
            <tr class="collapse">
              <td class="collapse">{{ $idx+1 }}</td>
              <td class="collapse">{{ $tackingout->tackingout->no_tacking }}</td>
              <td class="collapse">{{ $tackingout->tackingout->tgl_tacking }}</td>
              <td class="collapse">{{ $tackingout->tackingout->lokasi }}</td>
              <td class="collapse">{{ $tackingout->tackingout->receiveby }}</td>
              <td class="collapse">{{ $tackingout->barang->kd_brg." - ".$tackingout->barang->nm_brg }}</td>
              <td class="collapse">{{ $tackingout->qty_brg }} {{ $tackingout->barang->unit }}</td>
              <td class="collapse">{{ $tackingout->tackingout->tujuan }}</td>
            </tr>
            @endforeach
        </table>
      </main>
</body>