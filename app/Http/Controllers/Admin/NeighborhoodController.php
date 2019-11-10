<?php

namespace App\Http\Controllers\Admin;

use App\Models\Neighborhood;
use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NeighborhoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Neighborhood::paginate(5);
        return view('admin.neighborhood.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.neighborhood.create', compact('cities'));
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
            'name' => 'required',
            'city_id' => 'required'
        ];
        $message =[
            'name.required'=>'إسم الحي مطلوب',
            'city_id.required'=>'إسم المدينه مطلوب'
        ];
        $this->validate($request,$rules,$message);
        Neighborhood::create($request->all());
        flash()->success("تم الإضافه بنجاح");
        return redirect(route('neighborhood.index'));
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
        $model = Neighborhood::findOrFail($id);
        return view('admin.neighborhood.edit',compact('model'));
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
        $data = Neighborhood::findOrFail($id);
        $data->update($request->all());
        flash()->success('تم التحديث بنجاح');
        return redirect(route('neighborhood.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Neighborhood::findOrFail($id);
        $data->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect(route('neighborhood.index'));
    }
}
