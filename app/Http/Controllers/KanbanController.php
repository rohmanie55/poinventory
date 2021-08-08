<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\KanbanStatus;
use Illuminate\Support\Facades\Notification;
use App\Models\Kanban;
use App\Models\Goods;
use App\Models\KanbanDetail;
use App\User;
use DB;

class KanbanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kanban.index', [
            'kanbans'=> Kanban::with('details.barang:id,kd_brg,nm_brg,unit', 'user:id,name')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('kanban.create', [
            'goods'=>Goods::select('id', 'kd_brg','nm_brg', 'harga', 'unit')->get()
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
            'tgl_request'=> 'required',
            'tgl_butuh'  => 'nullable|after:tgl_request',
        ]);
            
        DB::transaction(function () use ($request){
            $last = Kanban::selectRaw('MAX(no_request) as number')->first();
            $no_request= "K".sprintf("%05s", substr($last->number, 1, 5)+1);
            $details = [];

            $kanban = Kanban::create([
                'no_request' => $no_request,
                'tgl_request'=> $request->tgl_request,
                'tgl_butuh'  => $request->tgl_butuh,
                'tujuan'     => $request->tujuan,
                'user_id'    => auth()->user()->id,
            ]);

            foreach($request->barang_id as $idx=>$barang_id){
                $details[] = ['barang_id'=>$barang_id, 'qty_request'=> $request->qty_request[$idx], 'kanban_id'=>$kanban->id, 'status'=>'requested'];
            }

            KanbanDetail::insert($details);

            //push notification to user purchasing
            Notification::send(User::where('role', 'purchasing')->get(), new KanbanStatus([
                "title" => "New kanban request",
                "body"  => "Please create purchase order for $kanban->no_request!",
                "url"   => route('order.create', ['kanban_id'=>$kanban->id]),
                "kanban_id"=> $kanban->id
            ]));
        });



        return redirect()->route('kanban.index')->with('message', 'Successfull creating kanban!');
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
        return view('kanban.edit', [
            'kanban' => Kanban::with('details')->findOrFail($id),
            'goods'  => Goods::select('id', 'kd_brg','nm_brg', 'harga', 'unit')->get()
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
            'tgl_request'=> 'required',
            'tgl_butuh'  => 'nullable|after:tgl_request',
        ]);

        DB::transaction(function () use ($request, $id){
            $forms   = collect();
            $details = KanbanDetail::where('request_id', $id)->get();

            foreach($request->barang_id as $idx=>$barang_id){
                $forms->push(['id'=>$request->id[$idx] ?? null, 'barang_id'=>$barang_id, 'qty_request'=> $request->qty_request[$idx], 'request_id'=>$id]);
            }

            Kanban::find($id)->update([
                'tgl_request'=> $request->tgl_request,
                'tgl_butuh'  => $request->tgl_butuh,
            ]);

            foreach($details as $detail){
                $form = $forms->where('id', $detail->id)->first();
                if($form){
                    $detail->barang_id  = $form['barang_id'];
                    $detail->qty_request= $form['qty_request'];
                    $detail->request_id= $form['request_id'];
                    $detail->save();
                }else{
                    $detail->delete();
                }
            }

            KanbanDetail::insert($forms->whereNull('id')->toArray());
        });

        return redirect()->route('kanban.index')->with('success', 'Successfull creating kanban!');
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
            Kanban::findOrFail($id)->delete();

            KanbanDetail::where('kanban_id', $id)->delete();

            return redirect()->route('kanban.index')->with('success', 'Successfull deleting kanban!');
       } catch (\Throwable $th) {
            return redirect()->route('kanban.index')->with('fail', 'Failed deleting kanban!');
       }
    }
}
