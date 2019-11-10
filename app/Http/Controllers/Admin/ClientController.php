<?php

namespace App\Http\Controllers\Admin;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rules = Client::paginate(5);
        return view('admin.client.index', compact('rules'));
    }

    public function clientstatus($id)
    {
        $rule = Client::findOrFail($id);
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
        $data = Client::findOrFail($id);
        $data->delete();
        flash()->success('تم الحذف بنجاح');
        return redirect(route('client.index'));
    }

    public function clientsearch()
    {
        $rules = Client::where(function ($q) {
            if (request()->input('neighborhood_id')) {
                    $q->where('neighborhood_id', request()->neighborhood_id);
                }
            if (request()->input('keyword')) {
                $q->where('name', 'like', '%' . request()->keyword . '%');
            }
        })->latest()->paginate(10);

        if ($rules->count() == 0) {
            flash('لا يوجد عملاء')->error();
            return redirect(route('client.index'));
        } else {
            return view('admin.client.index', compact('rules'));
        }
    }
}
