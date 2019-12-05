<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocalSemestersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('localsemester');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $datas = \App\Article::with('user')->orderBy('id', 'desc')->get();
		$datas = \App\Article::where('article_type', 'ls')->with('user')->orderby('id', 'desc')->get();
        return response()->json($datas);
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		
		 // $image = $request->file("image");
		 // $filename = Str::random(15).filter_var($image->getClientOriginalName(),FILTER_SANITIZE_URL);
		 // $image->move(public_path('images'),$filename);
        
		// $title = $request->title;
		// $content = $request->content;
		$id = auth()->user()->id;
		
		// $file = $request->file('file');
		// dd($file);
		
		 $file = $request->file("file");
		 $filename = Str::random(15).filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
		 $file->move(public_path('files/'),$filename);
		
        $localSemester = \App\User::find($id)->articles()->create([
			'title'=>$request->get('title'),
			'article_type'=>'ls',
			'content'=>$request->get('content'),
			'file'=>$filename,
        ]);
        $data = \App\Article::where('id',$localSemester->id)->with('user')->get();
        return response()->json($data, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = \App\Article::where('id', $id)->with('user')->get();
        return response()->json($data);
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
    // public function update(Request $request, $id)
    public function update(Request $request, $id)
    {           
        \App\Article::find($id)->update($request->all());
        // flash()->success('수정하신 내용을 저장했습니다.');

        return response()->json($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        \App\Article::find($id)->delete();
        return response()->json($id);
    }
}