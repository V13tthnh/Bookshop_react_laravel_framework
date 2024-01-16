<?php

namespace App\Http\Controllers;

use App\Http\Requests\APIReviewHandler;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\Book;
use DB;
class APIReviewController extends Controller
{
    public function getReviews($id)
    {   
        //Lấy danh sách cthd của khách hàng để kiểm tra xem đã mua hàng chưa
        $checkOrder = OrderDetail::with('order')->where('book_id', $id)->get();
        //Lấy danh sách đánh giá của sách
        $reviews = Review::with('customer')->where('book_id', $id)->where('status', 1)->orderBy('id', 'desc')->get();
        //Đếm số lượng số sao đánh giá và chuyển thành mảng
        $ratingsCount = Review::select('rating', DB::raw('COUNT(*) as count'))
        ->where('book_id', $id)
        ->groupBy('rating')
        ->pluck('count', 'rating')
        ->toArray();    
        $reviewCounter = Review::with('customer')->where('book_id', $id)->where('status', 1)->count();
        return response()->json([
            'success' => true,
            'checkOrder' => $checkOrder,
            'reviews' =>  $reviews,
            'rating_counter' => $ratingsCount,
            'review_counter' => $reviewCounter
        ]);
    }

    public function reviewHandler(APIReviewHandler $request)
    {
        $review = new Review;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->customer_id = $request->customer_id;
        $review->book_id = $request->book_id;
        $review->status = 0;
        $review->save();
       
        $totalStars = Review::where('status', 1)->where('book_id',  $review->book_id)->sum('rating');
        $totalReviews = Review::where('status', 1)->where('book_id',  $review->book_id)->count();
        $averageRating = ($totalReviews > 0) ? ($totalStars / $totalReviews) : 0;

        $setOverrate = Book::find($review->book_id);
        $setOverrate->overrate = number_format($averageRating, 1);
        $setOverrate->save();

        return response()->json([
            'success' => true,
            'message' => "Cảm ơn phản hồi của bạn về sản phẩm!",
        ]);
    }
}
