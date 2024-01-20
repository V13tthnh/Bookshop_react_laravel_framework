<?php

namespace App\Http\Controllers;

use App\Http\Requests\APICommentReplyRequest;
use App\Http\Requests\APICommentRequest;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;

class APICommentController extends Controller
{
    public function getBookComments($id){
        $comments = Comment::with('book', 'customer', 'comment_replies', 'comment_replies.customer', 'comment_replies.comment')->where('book_id', $id)->orderBy('id', 'desc')->get();
        if(empty($comments)){
            return response()->json([
                'success' => false,
                'message' => "Sản phẩm không có bình luận!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    public function getComboComments($id){
        $comments = Comment::with('combo', 'customer', 'comment_replies', 'comment_replies.customer', 'comment_replies.comment')->where('combo_id', $id)->orderBy('id', 'desc')->get();
        if(empty($comments)){
            return response()->json([
                'success' => false,
                'message' => "Sản phẩm không có bình luận!"
            ]);
        }
        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    public function comment(APICommentRequest $request){
        $comment = new Comment;
        $comment->book_id = $request->book_id;
        $comment->combo_id = $request->combo_id;
        $comment->customer_id = $request->customer_id;
        $comment->comment_text = $request->comment_text;
        $comment->status = 0;
        $comment->save();
        return response()->json([
            'success' => true,
        ]);
    }

    public function reply(APICommentReplyRequest $request, $id){
        $reply = new CommentReply;
        $reply->comment_id = $id;
        $reply->customer_id = $request->customer_id;
        $reply->reply_text = $request->reply_text;
        $reply->save();
        return response()->json([
            'success' => true,
        ]);
    }
}
