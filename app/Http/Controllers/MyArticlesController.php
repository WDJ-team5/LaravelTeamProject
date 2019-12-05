<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;

class MyArticlesController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth', ['except' => ['index','show']]);
    }
	
	
    public function index(Request $request)
    {
        
        if ($request->ajax()) {

			$data = \App\User::join('articles', function($join){
				$join->on('articles.user_id', '=', 'users.id')
					->where('users.name', '=' , auth()->user()->name);})
					->orderBy('articles.id','desc')
					->get();
						
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editMyArticle">수정하기</a>';
						$btn = $btn.'<span>&nbsp;&nbsp;</span>';
   
                           $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteMyArticle">삭제하기</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    
        return view('myarticle',compact('article'));
    }


	
    public function create()
    {
        //
    }

	
    public function store(Request $request)
    {
        
		auth()->user()->articles()->updateOrCreate(['id' => $request->myarticle_id], 
        ['title' => $request->title, 'content' => $request->content]);
        
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
			'title' => $request->title,
			'content' => $request->content
		]);
		
		return response()->json(['success'=>'Article updated successfully.']);
    }

	
	
    public function destroy($id)
    {
		$article = \App\Article::find($id);
		
        \App\Article::find($id)->delete();
     
        return response()->json(['success'=>'Article deleted successfully.']);
    }
}