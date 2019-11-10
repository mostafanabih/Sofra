<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Order::paginate(5);
        return view('admin.order.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rules = Order::find($id);
        return view('admin.order.detail',compact('rules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Order::findOrFail($id);
        $data->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect(route('order.index'));
    }

    public function ordersearch()
    {
        $rules = Order::where(function ($q) {
            if (request()->input('resturant_id')) {
                    $q->where('resturant_id', request()->resturant_id);
                }

            if (request()->input('keyword')) {
                $q->where('address', 'like', '%' . request()->keyword . '%');
            }
        })->latest()->paginate(10);

        if ($rules->count() == 0) {
            flash('لا يوجد طلبات')->error();
            return redirect(route('order.index'));
        } else {
            return view('admin.order.index', compact('rules'));
        }
    }
}
