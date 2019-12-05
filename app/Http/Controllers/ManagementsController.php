<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class ManagementsController extends Controller
{
    public function index(Request $request)
    {
		$this->authorize('admin');
		
		if($request->ajax()){
			$data=\App\User::where("id","!=",1)->get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="RankUp" class="edit btn btn-primary btn-sm rankUp">Up</a>';
					$btn = $btn.'<span>&nbsp;&nbsp;</span>';
					$btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="RankDown" class="edit btn btn-primary btn-sm rankDown">Down</a>';
					$btn = $btn.'<span>&nbsp;&nbsp;</span>';
					$btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser">Delete</a></div>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		
        return view('management',compact('user'));
		
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
		$this->authorize('admin');
		
		if($request->up == "up") {
			\App\User::whereId($id)->update(['rank' => 'B']);

			return response()->json(['success'=>'User rank up successfully.']);	
		}else {
			\App\User::whereId($id)->update(['rank' => 'C']);

			return response()->json(['success'=>'User rank up successfully.']);	
		}
		
    }

    public function destroy($id)
    {
		$this->authorize('admin');
		
 		\App\User::find($id)->delete();
		
		return response()->json(['success'=>'User deleted successfully.']);
		
    }
	
}
