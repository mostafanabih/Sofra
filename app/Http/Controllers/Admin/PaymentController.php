<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Payment::paginate(5);
        return view('admin.payment.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.payment.create', compact('resturants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules =[
            'resturant_id' => 'required',
            'paid' => 'required',
            'notes' => 'required'
        ];
        $message =[
            'resturant_id.required'=>'إسم المطعم مطلوب',
            'paid.required'=>'مطلوب إدخال المبلغ المدفوع',
            'notes.required'=>'الرجاء ادخال ملاحظاتك'
        ];
        $this->validate($request,$rules,$message);
        Payment::create($request->all());
        flash()->success("تم الإضافه بنجاح");
        return redirect(route('payment.index'));
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
        $model = Payment::findOrFail($id);
        return view('admin.payment.edit',compact('model'));
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
        $data = Payment::findOrFail($id);
        $data->update($request->all());
        flash()->success('تم التحديث بنجاح');
        return redirect(route('payment.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Payment::findOrFail($id);
        $data->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect(route('payment.index'));
    }

    public function search(Request $request)
    {
        $rules = Payment::with('resturant')->where(function ($query) use ($request) {
            if ($request->input('resturant_id')) {
                $query->where('resturant_id', $request->resturant_id);
            }
        })->latest()->paginate(10);

        if ($rules->count() == 0) {
            flash('لا يوجد مدفوعات علي هذا المطعم')->error();
            return redirect(route('payment.index'));
        }
        else{
            return view('admin.payment.index',compact('rules'));
        }
    }
}
