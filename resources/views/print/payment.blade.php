<!DOCTYPE html>
<html>
<head>
	<title>Laporan Pembayaran Terbaru</title>
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
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Pembayaran Terbaru</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
              <td class="collapse" style="width: 5%">#</td>
              <td class="collapse" style="width: 10%">No Invoice</td>
              <td class="collapse" style="width: 10%">No Surat Jalan</td>
              <td class="collapse" style="width: 10%">Tgl Trx</td>
              <td class="collapse" style="width: 25%">Nama Barang</td>
              <td class="collapse" style="width: 10%">Jumlah</td>
              <td class="collapse" style="width: 10%">Total</td>
            </tr>
            @foreach ($payments as $idx=>$payment)
            <tr class="collapse">
              <td class="collapse">{{ $idx+1 }}</td>
              <td class="collapse">{{ $payment->payment->no_inv }}</td>
              <td class="collapse">{{ $payment->payment->no_sj }}</td>
              <td class="collapse">{{ $payment->payment->tgl_trx }}</td>
              <td class="collapse">{{ $payment->barang->kd_brg." - ".$payment->barang->nm_brg }}</td>
              <td class="collapse">{{ $payment->qty_brg }} {{ $payment->barang->unit }}</td>
              <td class="collapse">@currency($payment->subtotal)</td>
            </tr>
            @endforeach
        </table>
      </main>
</body>