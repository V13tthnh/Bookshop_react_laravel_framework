<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Combo;
use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class ReviewController extends Controller
{
    public function index()
    {
        return view('review.index');
    }

    public function dataTable()
    {
        $reviews = Review::with('book', 'combo')->get();
       
        return Datatables::of($reviews)->addColumn('customer_name', function ($reviews) {
            return $reviews->customer->name;
        })->addColumn('book_name', function ($reviews) {
            return $reviews->book_id == null ? 'N/A' : $reviews->book->name;
        })->addColumn('combo_name', function ($reviews) {
            return $reviews->combo_id == null ? 'N/A': $reviews->combo->name;
        })->make(true);
    }

    public function update($id)
    {
        $review = Review::find($id);
        if (empty($review)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy dữ liệu đánh giá!'
            ]);
        }
        $review->status = 1;
        $review->save();
        
        if($review->book_id != null){
            $totalStars = Review::where('book_id',  $review->book_id)->sum('rating');
            $totalReviews = Review::where('book_id',  $review->book_id)->count();
            $averageRating = ($totalReviews > 0) ? ($totalStars / $totalReviews) : 0;

            $setOverrate = Book::find($review->book_id);
            $setOverrate->overrate = number_format($averageRating, 1);
            $setOverrate->save();
        } else {
            $totalStars = Review::where('combo_id',  $review->combo_id)->sum('rating');
            $totalReviews = Review::where('combo_id',  $review->combo_id)->count();
            $averageRating = ($totalReviews > 0) ? ($totalStars / $totalReviews) : 0;

            $setOverrate = Combo::find($review->combo_id);
            $setOverrate->overrate = number_format($averageRating, 1);
            $setOverrate->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Trạng thái đánh giá đã được cập nhật'
        ]);
    }

    public function updateStatus($id){
        $review = Review::find($id);
        if (empty($review)) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy dữ liệu đánh giá!'
            ]);
        }
        $review->status = -1;
        $review->save();

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá đã được ẩn!'
        ]);
    }

    public function destroy($id){
        Review::find($id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa đánh giá!'
        ]);
    }
}
