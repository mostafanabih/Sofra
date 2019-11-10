<?php

namespace App\Http\Controllers\Admin;

use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Resturant::paginate(5);
        return view('admin.Restaurant.index', compact('rules'));
    }

    public function status($id)
    {
        $rule = Resturant::findOrFail($id);
        if($rule->status == 'active'){
            $rule->status = 'deactive';
            $rule->update(['status' =>$rule->status]);
        }
        else{
            $rule->status = 'active';
            $rule->update(['status' =>$rule->status]);
        }
        return back();
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
        $rules = Resturant::find($id);
        return view('admin.Restaurant.detail',compact('rules'));
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
        $data = Resturant::findOrFail($id);
        $data->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect(route('restaurant.index'));
    }

    public function restaurantsearch()
    {
        $rules = Resturant::where(function ($query) {
            if (request()->input('city_id')) {
                $query->whereHas('neighborhood', function ($q) {
                    $q->where('city_id', request()->city_id);
                });
            }
            if (request()->input('keyword')) {
                $query->where('name', 'like', '%' . request()->keyword . '%');
            }
        })->latest()->paginate(10);

        if ($rules->count() == 0) {
            flash('لا يوجد مطاعم')->error();
            return redirect(route('restaurant.index'));
        } else {
            return view('admin.Restaurant.index', compact('rules'));
        }
    }
}
