<?php

namespace App\Http\Controllers;

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
        $reviews = Review::all();
        return Datatables::of($reviews)->addColumn('customer_name', function ($reviews) {
            return $reviews->customer->name;
        })->addColumn('book_name', function ($reviews) {
            return $reviews->book->name;
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
