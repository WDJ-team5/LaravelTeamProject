<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class QnAsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
	
    public function index(Request $request)
    {
		if ($request->ajax()) {
			$data = \App\User::join('articles', 'users.id', '=', 'articles.user_id')->where('article_type','QnA')->orderBy('articles.id','desc')->get();
			return Datatables::of($data)
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
	
        return view('qna',compact('article'));
    }

	public function create()
	{

	}

	public function store(Request $request)
	{
		auth()->user()->articles()->create([
			'article_type' => 'QnA',
			'title' => $request->title,
			'content' => $request->content
		]);

		return response()->json(['success'=>'Article saved successfully.']);
	}

	public function show($id)
	{
		$article = \App\Article::find($id);
		
		return response()->json($article);
	}

	public function edit($id)
	{	
		$article = \App\Article::find($id);
		
		$this->authorize('update', $article);
		
		return response()->json($article);
	}

	public function update(Request $request, $id)
	{
		\App\Article::find($id)->update([
			'article_type' => 'QnA',
			'title' => $request->title,
			'content' => $request->content
		]);
		
		return response()->json(['success'=>'Article updated successfully.']);
	}

	public function destroy($id)
	{
		$article = \App\Article::find($id);
		
		$this->authorize('update', $article);
		
		\App\Article::find($id)->delete();

		return response()->json(['success'=>'Article deleted successfully.']);
	}
}
