<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
class CommentController extends Controller
{
    public function index(){
        return view('comment.index'); 
    }

    public function dataTable()
    {
        $comments = Comment::with('customer', 'book', 'comment_replies')->get();
        return Datatables::of($comments)->addColumn('customer_name', function($comments){
            return $comments->customer->name;
        })->addColumn('book_id', function($comments){
            return $comments->book->name;
        })->addColumn('replies_count', function($comments){
            return count($comments->comment_replies);
        })->make(true);
    }

    public function dataTableDetail($id){
        $replies = CommentReply::with('customer')->where('comment_id', $id)->get();
        return Datatables::of($replies)->addColumn('customer_name', function($replies){
            return $replies->customer->name;
        })->make(true);
    }

    public function destroy($id)
    {
        Comment::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }


    public function destroyReply($id)
    {
        CommentReply::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => "Xóa thành công!"
        ]);
    }
    
}
