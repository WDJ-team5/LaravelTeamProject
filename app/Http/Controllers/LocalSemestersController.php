<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocalSemestersController extends Controller
{	
    public function index()
    {
		return view('localsemester');
		
    }

    public function create()
    {
		$datas = \App\Article::where('article_type', 'ls')->with('user')->orderBy('id', 'desc')->get();
		
		return response()->json($datas);
		
    }

    public function store(Request $request)
    {
		$filename = '';
		$id = auth()->user()->id;
		
		$file = $request->file("file");
		$filename = Str::random(15).filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
		$file->move(public_path('files/'),$filename);
		
        $localSemester = \App\User::find($id)->articles()->create([
			'title'=>$request->get('title'),
			'article_type'=>'LS',
			'content'=>$request->get('content'),
			'file'=>$filename,
        ]);
		
        return response()->json(['success'=>'Artice create successfully']);
		
    }

    public function show($id)
    {
        $data = \App\Article::find($id);
		
        return response()->json($data);
		
    }

    public function edit($id)
    {
        $article = \App\Article::find($id);
		
		return response()->json($article);
    }

	public function update(Request $request, $id)
    {
        \App\Article::find($id)->update([
			'article_type' => 'LS',
			'title' => $request->get('title'),
			'content' => $request->get('content'),
		]);
		
#		return response()->json(['success'=>'Article updated successfully.']);
		return response()->json($request);
		
		
    }

    public function destroy($id)
    {
		$article = \App\Article::find($id);
		$image = $article->file;
		
		if($image !== null) {
			\File::delete(public_path('files/') . $image);
		}
		
		$article->delete();
		
        return response()->json(['success'=>'Artice deleted successfully.']);
		
    }
	
}