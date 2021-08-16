<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\KanbanStatus;
use Illuminate\Support\Facades\Notification;
use App\Models\Order;
use App\Models\Kanban;
use App\Models\OrderDetail;
use App\Models\KanbanDetail;
use App\Models\Goods;
use App\Models\Supplier;
use App\User;
use DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with(['request:id,no_request,tgl_request,tujuan','supplier', 'approve:id,name', 'details'=>function($query){
            $query->selectRaw("id, order_id, barang_id, kanban_det_id, qty_order, COALESCE((select SUM(qty_brg) FROM transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id WHERE transaction_details.order_det_id=order_details.id AND transactions.type='returned' GROUP BY order_det_id) ,0) qty_return, subtotal")
                ->with('request:id,status', 'barang:id,kd_brg,nm_brg,unit');
        }])->get();
 
        return view('order.index', [
            'orders'=> $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(isset($_GET['kanban_id'])){
            auth()->user()->notifications()->where('data->kanban_id', $_GET['kanban_id'])->update(['read_at' => now()]);
        }

        $kanbans = Kanban::with(['user:id,name', 'details'=> function ($query) {
            $query->selectRaw("kanban_details.id,kanban_id,kanban_details.barang_id,qty_request,  (qty_request - COALESCE(SUM(qty_order), 0)) qty_sisa, goods.id b_id, kd_brg, nm_brg,harga")
            ->leftJoin(
                DB::raw("(SELECT id, kanban_det_id, (qty_order-COALESCE((select SUM(qty_brg) FROM transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id WHERE transaction_details.order_det_id=order_details.id AND transactions.type='returned' GROUP BY order_det_id) ,0)) qty_order FROM order_details) order_details"), 
                'kanban_details.id', '=', 'order_details.kanban_det_id')
            ->leftJoin('goods', 'goods.id', '=', 'kanban_details.barang_id')
            ->groupBy("kanban_details.id");
        }])->get()
        ->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('order.create', [
            'suppliers'=> Supplier::select('id', 'kd_supp', 'nama')->get(),
            'kanbans'  => $kanbans,
            'kanban_id'=> $_GET['kanban_id'] ?? null
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
            'tgl_order'  => 'required',
            'supplier_id' => 'required',
            'kanban_id' => 'required'
        ]);

        DB::transaction(function () use ($request){

            $last = Order::selectRaw('MAX(no_order) as number')->first();
            $no_order= "O".sprintf("%05s", substr($last->number, 1, 5)+1);
            $requestor = Kanban::select('id','user_id')->find($request->kanban_id);
            $details = [];
            $detail_id = [];

            $po = Order::create([
                'no_order'  => $no_order,
                'tgl_order' => $request->tgl_order,
                'total'     => $request->total,
                'suplier_id'=> $request->supplier_id,
                'kanban_id' => $request->kanban_id,
                'user_id'   => auth()->user()->id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                if($request->qty_order[$idx]>0){
                    $details[] = [
                        'order_id' =>$po->id,
                        'barang_id'=>$barang_id,
                        'kanban_det_id'=>$request->detail_id[$idx],
                        'qty_order'=>$request->qty_order[$idx],
                        'subtotal' =>$request->subtotal[$idx]
                    ];

                    $detail_id[] = $request->detail_id[$idx];
                }
            }

            OrderDetail::insert($details);

            KanbanDetail::whereIn('id', $detail_id)->update(['status'=>'ordered']);

            //push notification to produksi
            Notification::send(User::find($requestor->user_id), new KanbanStatus([
                "title" => "Kanban request ordered",
                "body"  => "Purchase order has assigned with number $po->no_order!",
                "order_id"=> $po->id
            ]));

            //push notification to manager
            Notification::send(User::where('role', 'manager')->get(), new KanbanStatus([
                "title" => "New purchase ordered",
                "body"  => "Please approve order with number $po->no_order!",
                "order_id"=> $po->id
            ]));
        });

        return redirect()->route('order.index')->with('message', 'Successfull creating order!');
    }

        /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $order = Order::findOrFail($id);
        
        $order->update([
            'approve_at' => now()->toDateTimeString(),
            'approve_id' => auth()->user()->id,
        ]);

        //push notification to purchasing
        Notification::send(User::find($order->user_id), new KanbanStatus([
            "title"   => "Purchase ordered has approved!",
            "body"    => "Order number $order->no_order has approved by ".auth()->user()->name,
            "order_id"=> $order->id
        ]));

        //push notification to finance
        // Notification::send(User::where('role', 'finance')->get(), new KanbanStatus([
        //     "title"   => "New ordered need to process!",
        //     "body"    => "Please process order number $order->no_order",
        //     "order_id"=> $order->id
        // ]));

        return redirect()->route('order.index')->with('message', 'Successfull approving order !');
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
        $kanbans = Kanban::with(['user:id,name', 'details'=> function ($query) {
            $query->selectRaw("kanban_details.id,kanban_id,kanban_details.barang_id,qty_request,  (qty_request - COALESCE(SUM(qty_order), 0)) qty_sisa, goods.id b_id, kd_brg, nm_brg,harga")
            ->leftJoin(
                DB::raw("(SELECT id, kanban_det_id, (qty_order-COALESCE((select SUM(qty_brg) FROM transaction_details INNER JOIN transactions on transactions.id=transaction_details.trx_id WHERE transaction_details.order_det_id=order_details.id AND transactions.type='returned' GROUP BY order_det_id) ,0)) qty_order FROM order_details) order_details"), 
                'kanban_details.id', '=', 'order_details.kanban_det_id')
            ->leftJoin('goods', 'goods.id', '=', 'kanban_details.barang_id')
            ->groupBy('kanban_details.id');
        }])->get()->transform(function ($item, $key) {
            $item->detaile = $item->details->where('qty_sisa', '>', 0);
            $item->detaile = $item->detaile->count()>0 ? $item->detaile : null;
            unset($item->details);
            return $item;
        });

        return view('order.edit', [
            'order'    => Order::with('details')->find($id),
            'suppliers'=> Supplier::select('id', 'kd_supp', 'nama')->get(),
            'kanbans' => $kanbans,
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
        DB::transaction(function () use ($request, $id){

            $details = [];
            $detail_id = [];

            Order::find($id)->update([
                'tgl_order'=> $request->tgl_order,
                'total'    => $request->total,
                'suplier_id'=> $request->supplier_id,
                'kanban_id'=> $request->kanban_id,
            ]);

            //update kanban status and remove old data
            if(!empty($request->barang_id)){
                $order_detail =OrderDetail::where('order_id', $id);
                $old_order    =$order_detail->get()->pluck('kanban_det_id');
                KanbanDetail::whereIn('id', $old_order)->update(['status'=>'requested']);
                $order_detail->delete();

                foreach($request->barang_id as $idx=>$barang_id){
                    if($request->qty_order[$idx]>0){
                        $details[] = [
                            'order_id' =>$id,
                            'barang_id'=>$barang_id,
                            'kanban_det_id'=>$request->detail_id[$idx],
                            'qty_order'=>$request->qty_order[$idx],
                            'subtotal' =>$request->subtotal[$idx]
                        ];

                        $detail_id[] = $request->detail_id[$idx];
                    }
                }

                OrderDetail::insert($details);

                KanbanDetail::whereIn('id', $detail_id)->update(['status'=>'ordered']);
            }
        });

        return redirect()->route('order.index')->with('message', 'Successfull updating order!');
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
            $order = Order::with('details:id,order_id,kanban_det_id')->findOrFail($id);

            KanbanDetail::whereIn('id', $order->details->pluck('kanban_det_id')->toArray())->update(['status'=>'requested']);

            $order->delete();

            OrderDetail::where('order_id', $id)->delete();

            return redirect()->route('order.index')->with('success', 'Successfull deleting order !');
       } catch (\Throwable $th) {
            return redirect()->route('order.index')->with('fail', 'Failed deleteing order!');
       }
    }
}
