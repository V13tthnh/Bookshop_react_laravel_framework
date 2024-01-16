<?php

namespace App\Http\Controllers;

use App\Http\Requests\APICommentReplyRequest;
use App\Http\Requests\APICommentRequest;
use App\Models\Comment;
use App\Models\CommentReply;
use Illuminate\Http\Request;

class APICommentController extends Controller
{
    public function getComments($id){
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

    public function comment(APICommentRequest $request, $id){
        $comment = new Comment;
        $comment->book_id = $id;
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
