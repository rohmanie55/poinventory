<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.index', ['suppliers'=> Supplier::get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('supplier.create');
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
            'kd_supp'=> 'required|max:100|unique:suppliers',
            'nama'=> 'required|max:255',
        ]);

        Supplier::create($request->all());

        return redirect()->route('supplier.index')->with('message', 'Successfull creating supplier !');
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
        return view('supplier.edit', ['supplier' => Supplier::findOrFail($id)]);
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
            'kd_supp' => 'required|max:100|unique:suppliers,kd_supp,'.$id,
            'nama'=> 'required|max:255',
        ]);

        Supplier::find($id)->update($request->all());

        return redirect()->route('supplier.index')->with('success', 'Successfull Updating Supplier !');
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
            Supplier::findOrFail($id)->delete();

            return redirect()->route('supplier.index')->with('success', 'Successfull deleting supplier!');
       } catch (\Throwable $th) {
            return redirect()->route('supplier.index')->with('fail', 'Failed deleteing supplier !');
       }
    }
}
