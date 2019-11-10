<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Review::paginate(5);
        return view('admin.comment.index', compact('rules'));
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
        $data = Review::findOrFail($id);
        $data->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect(route('review.index'));
    }

    public function reviewsearch(Request $request)
    {
        $rules = Review::with('resturant')->where(function ($query) use ($request) {
            if ($request->input('resturant_id')) {
                $query->where('resturant_id', $request->resturant_id);
            }
        })->latest()->paginate(10);

        if ($rules->count() == 0) {
            flash('لا يوجد تعليقات علي هذا المطعم')->error();
            return redirect(route('review.index'));
        }
        else{
            return view('admin.comment.index',compact('rules'));
        }
    }

}
