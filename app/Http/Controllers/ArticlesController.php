<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article; 
use App\Attachment;
use DataTables;

class ArticlesController extends Controller
{
	
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = Article::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editArticle">수정하기</a>';
   
                           $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteArticle">삭제하기</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $article = Article::latest()->get();
        //article db가져옴
		
     
        return view('article',compact('article'));
    }

    public function create()
    {

    }

    //게시글 저장
    public function store(Request $request)
    {	
        auth()->user()->articles()->updateOrCreate(['id' => $request->article_id], 
        ['title' => $request->title, 'content' => $request->content]);
        
        return response()->json(['success'=>'Article saved successfully.']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $article = Article::find($id);
        return response()->json($article);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Article::find($id)->delete();
     
        return response()->json(['success'=>'Article deleted successfully.']);
    }
}
