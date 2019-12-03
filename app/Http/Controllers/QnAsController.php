<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article; 
use DataTables;

class QnAsController extends Controller
{
	
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = Article::latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editQnA">수정하기</a>';
   
                           $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteQnA">삭제하기</a>';
							
							$btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="show" class="btn btn-primary btn-sm showQnA">읽기</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        $article = Article::latest()->get();
        //article db가져옴
		
     
        return view('qna',compact('article'));
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
        $article = Article::find($id);
        return response()->json($article);
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
