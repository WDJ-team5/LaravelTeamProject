<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class ManagementsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		if($request->ajax()){
			$data=\App\User::get();
			return DataTables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$btn = '<div class="text-center"><a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="show" class="btn btn-primary btn-sm showQnA">Show</a>';
					$btn = $btn.'<span>&nbsp;&nbsp;</span>';
					$btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-success btn-sm editQnA">Edit</a>';
					$btn = $btn.'<span>&nbsp;&nbsp;</span>';
					$btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteQnA">Delete</a></div>';
					return $btn;
				})
				->rawColumns(['action'])
				->make(true);
		}
		
		// if($request->ajax()){
		// 	$data=\App\User::get();
		// 	return DataTables::of($data)
		// 		->addIndexColumn()
		// 		->addColumn('action',function($row){
		// 			 $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="RankUp" class="up btn btn-primary btn-sm rankUp">Rank Up</a>';
					
		// 			return $btn;
		// 		})
		// 		->rowColumns(['action'])
		// 		->make(true);
		// }
		
        return view('management',compact('user'));
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
        //
    }
}
