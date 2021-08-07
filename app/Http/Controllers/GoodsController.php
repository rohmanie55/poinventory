<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Goods;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('goods.index', ['goods'=> Goods::latest()->get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('goods.create');
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
            'kd_brg'=> 'required|max:100|unique:goods',
            'nm_brg'=> 'required|max:255',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Goods::create($request->all());

        return redirect()->route('goods.index')->with('message', 'Successfull creating goods!');
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
        return view('goods.edit', ['goods' => Goods::findOrFail($id)]);
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
            'kd_brg' => 'required|max:100|unique:goods,kd_brg,'.$id,
            'nm_brg' => 'required|max:255',
            'harga' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Goods::find($id)->update($request->all());

        return redirect()->route('goods.index')->with('success', 'Successfull updating goods!');
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
            Goods::findOrFail($id)->delete();

            return redirect()->route('goods.index')->with('success', 'Successfull deleting goods !');
       } catch (\Throwable $th) {
            return redirect()->route('goods.index')->with('fail', 'Failed deleting goods !');
       }
    }
}
