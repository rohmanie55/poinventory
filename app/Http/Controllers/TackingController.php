<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tackingout;
use App\Models\TackingoutDetail;
use App\Models\Goods;
use DB;

class TackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tackingout.index', [
            'tackingouts'=> Tackingout::with('details.barang:id,kd_brg,nm_brg,unit', 'user:id,name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $goods = Goods::selectRaw('id, kd_brg, nm_brg, harga, unit, ((stock + COALESCE(qty_receive,0)) - COALESCE(qty_to, 0)) qty_sisa')
                ->leftjoin(DB::raw('(select SUM(qty_brg) as qty_to, barang_id from tackingout_details GROUP BY barang_id) tackingout'), 'goods.id', '=', 'tackingout.barang_id')
                ->leftjoin(DB::raw("(select SUM(qty_brg) as qty_receive, barang_id from transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id where transactions.type='received' GROUP BY barang_id) trx_receive"), 'goods.id', '=', 'trx_receive.barang_id')
                ->get();

        return view('tackingout.create', [
            'goods'=>$goods
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
            'no_tacking' =>  'required|max:10',
            'tgl_tacking'=> 'required',
            'receiveby'  => 'required',
        ]);

        DB::transaction(function () use ($request){
            $details = [];

            $to = Tackingout::create([
                'no_tacking' => $request->no_tacking,
                'tgl_tacking'=> $request->tgl_tacking,
                'lokasi'     => $request->lokasi,
                'tujuan'     => $request->tujuan,
                'receiveby'  => $request->receiveby,
                'user_id'    => auth()->user()->id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                $details[] = ['barang_id'=>$barang_id, 'qty_brg'=> $request->qty_brg[$idx], 'tacking_id'=>$to->id];
            }

            TackingoutDetail::insert($details);
        });



        return redirect()->route('tackingout.index')->with('message', 'Successfull creating tackingout!');
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
        $goods = Goods::selectRaw('id, kd_brg, nm_brg, harga, unit, ((stock + COALESCE(qty_receive,0)) - COALESCE(qty_to, 0)) qty_sisa')
            ->leftjoin(DB::raw('(select SUM(qty_brg) as qty_to, barang_id from tackingout_details GROUP BY barang_id) tackingout'), 'goods.id', '=', 'tackingout.barang_id')
            ->leftjoin(DB::raw("(select SUM(qty_brg) as qty_receive, barang_id from transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id where transactions.type='received' GROUP BY barang_id) trx_receive"), 'goods.id', '=', 'trx_receive.barang_id')
            ->get();

        return view('tackingout.edit', [
            'tackingout'=> Tackingout::with('details')->find($id),
            'goods'=>$goods
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
            'no_tacking' =>  'required|max:10',
            'tgl_tacking'=> 'required',
            'receiveby'  => 'required',
        ]);

        DB::transaction(function () use ($request, $id){
            $details = [];

            $to = Tackingout::find($id)->update([
                'no_tacking' => $request->no_tacking,
                'tgl_tacking'=> $request->tgl_tacking,
                'lokasi'     => $request->lokasi,
                'tujuan'     => $request->tujuan,
                'receiveby'  => $request->receiveby,
            ]);

            if(!empty($request->barang_id)){

                TackingoutDetail::where('tacking_id', $id)->delete();

                foreach($request->barang_id as $idx=>$barang_id){
                    $details[] = ['barang_id'=>$barang_id, 'qty_brg'=> $request->qty_brg[$idx], 'tacking_id'=>$id];
                }

                TackingoutDetail::insert($details);
            }
        });



        return redirect()->route('tackingout.index')->with('message', 'Successfull creating tackingout!');
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
            Tackingout::findOrFail($id)->delete();

            TackingoutDetail::where('tacking_id', $id)->delete();

            return redirect()->route('tackingout.index')->with('success', 'Successfull deleting pengiriman !');
       } catch (\Throwable $th) {
            return redirect()->route('tackingout.index')->with('fail', 'Failed deleteing pengiriman!');
       }
    }
}
