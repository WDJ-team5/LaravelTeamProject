<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class TeamsController extends Controller
{
	public function index()
	{
		return view('team');
	}

    public function create()
    {
		$teams = \App\Team::with(array('user'=>function($query){
			$query->select('name','email','id','img');
		}))->get(['id','user_id']);
		
		if(!auth()->check()){
			return response()->json([$teams,true]);
		}
		
		$check = \App\Team::where('user_id',auth()->user()->id)->doesntExist();
		
		$user = auth()->user();
		
		if($check  && $user->rank === 'B'){
			return response()->json([$teams,false]);
		}
		
		return response()->json([$teams,true]);
    }

    public function store(Request $request)
    {
		if(!auth()->check()){
			return;
		}
        	
		$user = auth()->user();
		
		if($user->rank !== 'B' && $user->rank !== 'A'){
			return;
		}
			
		$comment = $request->comment;
        \App\User::find($user->id)->team()->create(['comment'=>$comment]);
		
        return response()->json(auth()->user());
    }

    public function show($id)
    {
        $team = \App\User::where('id',$id)->with('team')->get();
		
		if(!auth()->check()){
			return response()->json([$team,-1]);
		}
        $user = auth()->user();
		$data = $user->id;
		return response()->json([$team,$data]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
		$team = \App\Team::find($id);
		$this->authorize('update', $team);
        $team->update($request->all());
    }

    public function destroy($id)
    {	
		$team = \App\Team::find($id);
		$this->authorize('delete', $team);
		\App\Team::find($id)->delete();

		return response()->json([],204);	
    }
}
