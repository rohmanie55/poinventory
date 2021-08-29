<!DOCTYPE html>
<html>
<head>
	<title>Laporan Stock Terbaru</title>
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
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Stock Terbaru</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
                <td class="collapse" style="width: 5%">#</td>
                <td class="collapse" style="width: 10%">Kode</td>
                <td class="collapse" style="width: 30%">Nama Barang</td>
                <td class="collapse" style="width: 15%">Harga</td>
                <td class="collapse" style="width: 10%">Stok Awal</td>
                <td class="collapse" style="width: 10%">Stock In</td>
                <td class="collapse" style="width: 10%">Stock Out</td>
                <td class="collapse" style="width: 10%">Stok akhir</td>
                <td class="collapse" style="width: 20%">Satuan</td>
            </tr>
            @foreach ($goods as $idx=>$good)
            <tr class="collapse">
              <td class="collapse">{{ $idx+1 }}</td>
              <td class="collapse">{{ $good->kd_brg }}</td>
              <td class="collapse">{{ $good->nm_brg }}</td>
              <td class="collapse">@currency($good->harga)</td>
              <td class="collapse">{{ $good->stock }}</td>
              <td class="collapse">{{ $good->receive }}</td>
              <td class="collapse">{{ $good->tacking }}</td>
              <td class="collapse">{{ ($good->stock+$good->receive)-$good->tacking }}</td>
              <td class="collapse">{{ $good->unit }}</td>
            </tr>
            @endforeach
        </table>
      </main>
</body>