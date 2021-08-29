<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;
use App\Models\KanbanDetail;
use App\Models\OrderDetail;
use App\Models\TransactionDetail;
use App\Models\PaymentDetail;
use App\Models\TackingoutDetail;
use PDF;
use DB;

class ReportController extends Controller
{
    public function stock()
    {
        $goods = Goods::selectRaw('id, kd_brg, nm_brg, harga, unit, stock, COALESCE(qty_receive,0) receive, COALESCE(qty_to, 0) tacking')
            ->leftjoin(DB::raw('(select SUM(qty_brg) as qty_to, barang_id from tackingout_details GROUP BY barang_id) tackingout'), 'goods.id', '=', 'tackingout.barang_id')
            ->leftjoin(DB::raw("(select SUM(qty_brg) as qty_receive, barang_id from transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id where transactions.type='received' GROUP BY barang_id) trx_receive"), 'goods.id', '=', 'trx_receive.barang_id')
            ->get();

        if(isset($_GET['print'])){
            return PDF::loadView('print.stock', ['goods'=>$goods])->stream('laporan_stock_terbaru.pdf');
        }

        return view('report.report-stock', [
            'goods'=>$goods
        ]);
    }

    public function kanban(){
        $start = isset($_GET['start']) ? $_GET['start'] : now()->subDay(30)->toDateString();
        $end   = isset($_GET['end']) ? $_GET['end'] : now()->toDateString();

        $kanbans = KanbanDetail::with('kanban:id,no_request,tgl_request,tujuan', 'barang:id,kd_brg,nm_brg,unit')->whereHas('kanban', function($query) use($start, $end){
            $query->whereBetween('tgl_request', [$start, $end]);
        })->get();

        if(isset($_GET['print'])){
            return PDF::loadView('print.kanban', ['kanbans'=>$kanbans])->stream('laporan_kanban_terbaru.pdf');
        }

        return view('report.report-kanban', [
            'kanbans'=> $kanbans,
            'start' => $start,
            'end'   => $end
        ]);
    }

    public function order(){
        $start = isset($_GET['start']) ? $_GET['start'] : now()->subDay(30)->toDateString();
        $end   = isset($_GET['end']) ? $_GET['end'] : now()->toDateString();

        $orders = OrderDetail::selectRaw("order_details.*, COALESCE((select SUM(qty_brg) FROM transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id WHERE transaction_details.order_det_id=order_details.id AND transactions.type='returned' GROUP BY order_det_id) ,0) qty_return")->with('order:id,no_order,tgl_order,suplier_id', 'order.supplier:id,kd_supp,nama', 'barang:id,kd_brg,nm_brg,unit')
        ->whereHas('order', function($query) use($start, $end){
            $query->whereBetween('tgl_order', [$start, $end]);
        })->get();

        if(isset($_GET['print'])){
            return PDF::loadView('print.order', ['orders'=>$orders])->stream('laporan_order_terbaru.pdf');
        }
  
        return view('report.report-order', [
            'orders'=> $orders,
            'start' => $start,
            'end'   => $end
        ]);
    }

    public function trx(){
        $start = isset($_GET['start']) ? $_GET['start'] : now()->subDay(30)->toDateString();
        $end   = isset($_GET['end']) ? $_GET['end'] : now()->toDateString();

        $trxs = TransactionDetail::with('transaction:id,no_trx,tgl_trx,type', 'barang:id,kd_brg,nm_brg,unit')->whereHas('transaction', function($query) use($start, $end){
            $query->whereBetween('tgl_trx', [$start, $end]);
        })->get();

        if(isset($_GET['print'])){
            return PDF::loadView('print.trx', ['trxs'=>$trxs])->stream('laporan_penerimaan_terbaru.pdf');
        }
        
        return view('report.report-trx', [
            'trxs'=> $trxs,
            'start' => $start,
            'end'   => $end
        ]);
    }

    public function payment(){
        $start = isset($_GET['start']) ? $_GET['start'] : now()->subDay(30)->toDateString();
        $end   = isset($_GET['end']) ? $_GET['end'] : now()->toDateString();

        $payments = PaymentDetail::with('payment:id,no_inv,no_sj,tgl_trx', 'barang:id,kd_brg,nm_brg,unit')->whereHas('payment', function($query) use($start, $end){
            $query->whereBetween('tgl_trx', [$start, $end]);
        })->get();

        if(isset($_GET['print'])){
            return PDF::loadView('print.payment', ['payments'=>$payments])->stream('laporan_pembayaran_terbaru.pdf');
        }
        
        return view('report.report-payment', [
            'payments'=> $payments,
            'start' => $start,
            'end'   => $end
        ]);
    }

    public function tacking(){
        $start = isset($_GET['start']) ? $_GET['start'] : now()->subDay(30)->toDateString();
        $end   = isset($_GET['end']) ? $_GET['end'] : now()->toDateString();

        $tackingouts = TackingoutDetail::with('tackingout', 'barang:id,kd_brg,nm_brg,unit')->whereHas('tackingout', function($query) use($start, $end){
            $query->whereBetween('tgl_tacking', [$start, $end]);
        })->get();

        if(isset($_GET['print'])){
            return PDF::loadView('print.tacking', ['tackingouts'=>$tackingouts])->stream('laporan_pengiriman_terbaru.pdf');
        }
        
        return view('report.report-tacking', [
            'tackingouts'=> $tackingouts,
            'start' => $start,
            'end'   => $end
        ]);
    }
}
