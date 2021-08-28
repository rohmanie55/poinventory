<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\PaymentDetail;
use DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment.index', [
            'payments'=> Payment::with('details.barang:id,kd_brg,nm_brg,unit', 'user:id,name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $transactions = Transaction::with(['details'=> function ($query) {
            $query->selectRaw('transaction_details.id,trx_id,transaction_details.barang_id,transaction_details.qty_brg, transaction_details.qty_brg - COALESCE(SUM(payment_details.qty_brg), 0) as qty_sisa, goods.id b_id, kd_brg, nm_brg, harga')
            ->leftJoin('payment_details', 'transaction_details.id', '=', 'payment_details.trx_det_id')
            ->leftJoin('goods', 'goods.id', '=', 'transaction_details.barang_id')
            ->groupBy('transaction_details.id');
        }])->where('type', 'received')->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('payment.create', [
            'transactions' => $transactions
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
            'tgl_trx'  => 'required',
            'trx_id' => 'required',
            'no_sj' => 'required',
            'no_inv' => 'required',
        ]);

        DB::transaction(function () use ($request){
            $details = [];

            $trx = Payment::create([
                'tgl_trx'   => $request->tgl_trx,
                'trx_id'    => $request->trx_id,
                'no_sj'     => $request->no_sj,
                'no_inv'    => $request->no_inv,
                'user_id'   => auth()->user()->id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                if($request->qty_brg[$idx]>0){
                    $details[] = [
                        'payment_id'=>$trx->id,
                        'barang_id' =>$barang_id,
                        'trx_det_id'=>$request->detail_id[$idx],
                        'qty_brg'   =>$request->qty_brg[$idx],
                        'subtotal'  =>$request->subtotal[$idx]
                    ];
                }
            }

            PaymentDetail::insert($details);

        });

        return redirect()->route('payment.index')->with('message', 'Successfull creating payment!');
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
        $transactions = Transaction::with(['details'=> function ($query) {
            $query->selectRaw('transaction_details.id,trx_id,transaction_details.barang_id,transaction_details.qty_brg, transaction_details.qty_brg - COALESCE(SUM(payment_details.qty_brg), 0) as qty_sisa, goods.id b_id, kd_brg, nm_brg, harga')
            ->leftJoin('payment_details', 'transaction_details.id', '=', 'payment_details.trx_det_id')
            ->leftJoin('goods', 'goods.id', '=', 'transaction_details.barang_id')
            ->groupBy('transaction_details.id');
        }])->where('type', 'received')->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('payment.edit', [
            'payment' => Payment::with('details')->find($id),
            'transactions'=> $transactions,
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
            'tgl_trx'  => 'required',
            'trx_id' => 'required',
            'no_sj' => 'required',
            'no_inv' => 'required',
        ]);

        DB::transaction(function () use ($request, $id){
            $details = [];

            $trx = Payment::find($id)->update([
                'tgl_trx'   => $request->tgl_trx,
                'trx_id'    => $request->trx_id,
                'no_sj'     => $request->no_sj,
                'no_inv'    => $request->no_inv,
            ]);

            //update kanban status and remove old data
            if(!empty($request->barang_id)){
                PaymentDetail::where('payment_id', $id)->delete();

                foreach($request->barang_id as $idx=>$barang_id){
                    if($request->qty_brg[$idx]>0){
                        $details[] = [
                            'payment_id'=>$trx->id,
                            'barang_id' =>$barang_id,
                            'trx_det_id'=>$request->detail_id[$idx],
                            'qty_brg'   =>$request->qty_brg[$idx],
                            'subtotal'  =>$request->subtotal[$idx]
                        ];
                    }
                }

                PaymentDetail::insert($details);
        }

        });

        return redirect()->route('payment.index')->with('message', 'Successfull creating payment!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Payment::findOrFail($id)->delete();

            PaymentDetail::where('payment_id', $id)->delete();

            return redirect()->route('payment.index')->with('success', 'Successfull deleting payment !');
       } catch (\Throwable $th) {
            return redirect()->route('payment.index')->with('fail', 'Failed deleteing payment!');
       }
    }
}
