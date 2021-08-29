<!DOCTYPE html>
<html>
<head>
	<title>Laporan Order Terbaru</title>
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
        <div style="text-align: center;padding-top: 10px;"><h3>Laporan Order Terbaru</h3></div>
        <table style="width: 100%" class="collapse">
            <tr class="collapse">
              <td class="collapse" style="width: 5%">#</td>
              <td class="collapse" style="width: 10%">No Order</td>
              <td class="collapse" style="width: 10%">Tgl Order</td>
              <td class="collapse" style="width: 25%">Nama Barang</td>
              <td class="collapse" style="width: 10%">Jumlah</td>
              <td class="collapse" style="width: 10%">Di return</td>
              <td class="collapse" style="width: 10%">Total</td>
              <td class="collapse" style="width: 20%">Supplier</td>
            </tr>
            @foreach ($orders as $idx=>$order)
            <tr class="collapse">
              <td class="collapse">{{ $idx+1 }}</td>
              <td class="collapse">{{ $order->order->no_order }}</td>
              <td class="collapse">{{ $order->order->tgl_order }}</td>
              <td class="collapse">{{ $order->barang->kd_brg." - ".$order->barang->nm_brg }}</td>
              <td class="collapse">{{ $order->qty_order }} {{ $order->barang->unit }}</td>
              <td class="collapse">{{ $order->qty_return }} {{ $order->barang->unit }}</td>
              <td class="collapse">@currency($order->subtotal)</td>
              <td class="collapse">{{ $order->order->supplier->kd_supp }} - {{ $order->order->supplier->nama }}</td>
            </tr>
            @endforeach
        </table>
      </main>
</body>