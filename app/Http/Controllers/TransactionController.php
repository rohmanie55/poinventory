<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\KanbanStatus;
use Illuminate\Support\Facades\Notification;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\KanbanDetail;
use App\User;
use File;
use DB;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('penerimaan.index', [
            'transactions'=> Transaction::with('details.barang:id,kd_brg,nm_brg,unit', 'user:id,name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $orders = Order::with(['details'=> function ($query) {
            $query->selectRaw('order_details.id,order_id,order_details.barang_id,qty_order, qty_order - COALESCE(SUM(qty_brg), 0) as qty_sisa, goods.id b_id, kd_brg, nm_brg, kanban_det_id')
            ->leftJoin('transaction_details', 'order_details.id', '=', 'transaction_details.order_det_id')
            ->leftJoin('goods', 'goods.id', '=', 'order_details.barang_id')
            ->groupBy('order_details.id');
        }, 'supplier:id,nama'])->whereNotNull('approve_id')->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('penerimaan.create', [
            'orders' => $orders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_trx'  => 'required|max:10',
            'tgl_trx'  => 'required',
            'order_id' => 'required',
            'bukti_sj' => 'nullable|mimes:jpg,png,jpeg,pdf',
            'bukti_in' => 'nullable|mimes:jpg,png,jpeg,pdf',
        ]);

        if($request->hasFile('bukti_sj')){
            $request['sj'] = md5(time()).'.'.$request->file('bukti_sj')->getClientOriginalExtension();

            $request->file('bukti_sj')->move(storage_path('app/public/trx/sj'), $request->sj);
        }

        if($request->hasFile('bukti_in')){
            $request['in'] = md5(time()).'.'.$request->file('bukti_in')->getClientOriginalExtension();

            $request->file('bukti_in')->move(storage_path('app/public/trx/in'), $request->in);
        }

        DB::transaction(function () use ($request){
            $requestor = Order::select('id','user_id','kanban_id','no_order')->with('request:id,no_request,user_id')->find($request->order_id);
            $details = [];

            $trx = Transaction::create([
                'no_trx'    => $request->no_trx,
                'tgl_trx'   => $request->tgl_trx,
                'type'      => $request->type,
                'order_id'  => $request->order_id,
                'bukti_sj'  => $request->sj ?? null,
                'bukti_in'  => $request->in ?? null,
                'user_id'   => auth()->user()->id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                if($request->qty_order[$idx]>0){
                    $details[] = [
                        'trx_id' =>$trx->id,
                        'barang_id'=>$barang_id,
                        'order_det_id'=>$request->detail_id[$idx],
                        'qty_brg'=>$request->qty_order[$idx],
                        'note'   =>$request->note[$idx]
                    ];
                }
            }

            TransactionDetail::insert($details);

            KanbanDetail::whereIn('id', $request->kanban_det_id)->update(['status'=> $request->type]);

            //push notification to produksi/purchasing
            $target_id = $request->type=='received' ? $requestor->request->user_id : $requestor->user_id;

            Notification::send(User::find($target_id), new KanbanStatus([
                "title" => $request->type=='received' ? "Kanban request received" : "Purchase order returned",
                "body"  => $request->type=='received' ? "Kanban request with number {$requestor->request->no_request} has received!" : "Please check returned order with number {$requestor->no_order}",
                "order_id"=> $request->order_id
            ]));

        });

        return redirect()->route('transaction.index')->with('message', 'Successfull creating transaction!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $orders = Order::with(['details'=> function ($query) {
            $query->selectRaw('order_details.id,order_id,order_details.barang_id,qty_order, (qty_order - COALESCE(SUM(qty_brg), 0)) as qty_sisa, goods.id b_id, kd_brg, nm_brg, kanban_det_id')
            ->leftJoin(
            DB::raw("(select transaction_details.id, order_det_id, qty_brg from transaction_details inner join transactions on transaction_details.trx_id=transactions.id where type='received') transaction_details")
            , 'order_details.id', '=', 'transaction_details.order_det_id')
            ->leftJoin('goods', 'goods.id', '=', 'order_details.barang_id')
            ->groupBy('order_details.id');
        }, 'supplier:id,nama'])->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('penerimaan.edit', [
            'transaction' => Transaction::with('details')->find($id),
            'orders'=> $orders,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'no_trx'   => 'required|max:10',
            'tgl_trx'  => 'required',
            'order_id' => 'required',
            'bukti_sj' => 'nullable|mimes:jpg,png,jpeg,pdf',
            'bukti_in' => 'nullable|mimes:jpg,png,jpeg,pdf',
        ]);

        $trx = Transaction::find($id);

        if($request->hasFile('bukti_sj')){
            try {
                is_null($trx->bukti_sj) ?: unlink(storage_path('app/public/trx/sj/').$trx->bukti_sj);
            } catch (\Throwable $th) {
                //throw $th;
            }
            $request['sj'] = md5(time()).'.'.$request->file('bukti_sj')->getClientOriginalExtension();

            $request->file('bukti_sj')->move(storage_path('app/public/trx/sj'), $request->sj);
        }

        if($request->hasFile('bukti_in')){
            try {
                is_null($trx->bukti_in) ?: unlink(storage_path('app/public/trx/in/').$trx->bukti_in);
            } catch (\Throwable $th) {
                //throw $th;
            }
            $request['in'] = md5(time()).'.'.$request->file('bukti_in')->getClientOriginalExtension();

            $request->file('bukti_in')->move(storage_path('app/public/trx/in'), $request->in);
        }

        DB::transaction(function () use ($request, $id, $trx){

            $details = [];
            $trx->no_trx    = $request->no_trx;
            $trx->bukti_sj  = $request->sj ? $request->sj : $trx->bukti_sj;
            $trx->bukti_in  = $request->in ? $request->in : $trx->bukti_in;
            $trx->tgl_trx   = $request->tgl_trx;
            $trx->type      = $request->type;
            $trx->order_id  = $request->order_id;
            $trx->save();

            //update kanban status and remove old data
            if(!empty($request->barang_id)){
                $trx_detail =TransactionDetail::where('trx_id', $id)->delete();

                KanbanDetail::whereIn('id', $request->kanban_det_id)->update(['status'=>'ordered']);

                foreach($request->barang_id as $idx=>$barang_id){
                    if($request->qty_order[$idx]>0){
                        $details[] = [
                            'trx_id' =>$trx->id,
                            'barang_id'=>$barang_id,
                            'order_det_id'=>$request->detail_id[$idx],
                            'qty_brg'=>$request->qty_order[$idx],
                            'note'   =>$request->note[$idx]
                        ];
                    }
                }

                TransactionDetail::insert($details);

                KanbanDetail::whereIn('id', $request->kanban_det_id)->update(['status'=> $request->type]);
            }
        });

        return redirect()->route('transaction.index')->with('message', 'Successfull updating order!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trx = Transaction::findOrFail($id);

        try {
            is_null($trx->bukti_in) ?: unlink(storage_path('app/public/trx/sj/').$trx->bukti_sj);
            is_null($trx->bukti_in) ?: unlink(storage_path('app/public/trx/in/').$trx->bukti_in);
        } catch (\Throwable $th) {
            //throw $th;
        }

        try {

            $trx->delete();

            TransactionDetail::where('trx_id', $id)->delete();

            return redirect()->route('transaction.index')->with('success', 'Successfull deleting transaction !');
       } catch (\Throwable $th) {
            return redirect()->route('transaction.index')->with('fail', 'Failed deleteing transaction!');
       }
    }
}
