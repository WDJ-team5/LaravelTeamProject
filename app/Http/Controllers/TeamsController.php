<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('team');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $teams = \App\Team::with(array('user'=>function($query){
            $query->select('name','email','id');}))->get(['id','user_id']);
		if(!auth()->check())
        	return response()->json([$teams,true]);
		$check = \App\Team::where('user_id',auth()->user()->id)->doesntExist();
		$user = auth()->user();
		if($check  && ($user->rank === 'B' || $user->rank === 'A'))
        	return response()->json([$teams,false]);
		return response()->json([$teams,true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		if(!auth()->check())
        	return;
		$user = auth()->user();
		if($user->rank !== 'B' && $user->rank !== 'A')
			return;
		$comment = $request->comment;
        \App\User::find($user->id)->team()->create(['comment'=>$comment]);
        return response()->json(auth()->user());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = \App\User::where('id',$id)->with('team')->get();
		
		if(!auth()->check())
        	return response()->json([$team,-1]);
        $user = auth()->user();
		$data = $user->id;
		return response()->json([$team,$data]);
        //get / /{}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //get / /[]/edit
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
		$team = \App\Team::find($id);
		$this->authorize('update', $team);
        $team->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
		$team = \App\Team::find($id);
		$this->authorize('delete', $team);
        \App\Team::find($id)->delete();
        return response()->json([],204);

    }
}
