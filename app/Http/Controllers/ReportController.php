<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use DB;

class ReportController extends Controller
{
    public function stock()
    {
        $goods = Goods::selectRaw('id, kd_brg, nm_brg, harga, unit, ((stock + IFNULL(qty_receive,0)) - (IFNULL(qty_to, 0) + IFNULL(qty_return, 0))) qty_sisa')
            ->leftjoin(DB::raw('(select SUM(qty_brg) as qty_to, barang_id from tackingout_details GROUP BY barang_id) tackingout'), 'goods.id', '=', 'tackingout.barang_id')
            ->leftjoin(DB::raw('(select SUM(qty_brg) as qty_return, barang_id from transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id where transactions.type="returned" GROUP BY barang_id) trx_return'), 'goods.id', '=', 'trx_return.barang_id')
            ->leftjoin(DB::raw('(select SUM(qty_brg) as qty_receive, barang_id from transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id where transactions.type="received" GROUP BY barang_id) trx_receive'), 'goods.id', '=', 'trx_receive.barang_id')
            ->get();

        return view('report-stock', [
            'goods'=>$goods
        ]);
    }
}
