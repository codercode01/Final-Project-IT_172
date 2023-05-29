<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inmate;


class InmateController extends Controller
{
    public function showForm()
    {
        return view('Inmate.register_inmate');
    }

    public function save_inmate(Request $request)
    {
        
        $new_inmate = new Inmate;
        $new_inmate->inmate = $request->inmate;
        $new_inmate->violation = $request->violation;
        $new_inmate->address = $request->address;
        $new_inmate->citizenship = $request->citizenship;
        $new_inmate->status = $request->status;
        $new_inmate->Save();
        return redirect('/inmate-info');
    }

    public function View_inmate(Request $request)
    {
        $search = $request ['search'] ?? "";
        if ($search != ""){
            //where
            $inmates = Inmate::where('inmate','LIKE', "%$search%")->paginate(10);
        }else {
            $inmates = Inmate::orderBy("created_at", "asc")->get();
        }
         $inmate= compact('inmates','search');
        //$inmates = Inmate::all();
        return view('Inmate.inmate')->with($inmate);
    }

    public function delete_inmate(Request $request)
    {
        $response = Inmate::find($request->id)->delete();
        return $response;
    }

    public function update_inmate($id)
    {
        $update_inmate = Inmate::find($id);
        return view('Inmate.update-inmate', compact('update_inmate'));
    }

    public function save_inmate_update(Request $request, $id)
    {
        
        $update_inmate = Inmate::find($id);
        $update_inmate->inmate = $request->inmate;
        $update_inmate->violation = $request->violation;
        $update_inmate->address = $request->address;
        $update_inmate->citizenship = $request->citizenship;
        $update_inmate->status = $request->status;
        $update_inmate->Save();
        return redirect('/inmate-info');
    }
}
