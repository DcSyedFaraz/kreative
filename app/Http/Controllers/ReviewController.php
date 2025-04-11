<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $reviews = $user->reviews()->with('customer')->get();
        return view('reviews.index', compact('user', 'reviews'));
    }


    public function create($userId)
    {
        $user = User::findOrFail($userId);
        return view('reviews.create', compact('user'));
    }

    public function store(Request $request, $userId)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = new Review([
            'user_id' => $userId,
            'customer_id' => Auth::id(),
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        $review->save();

        return redirect()->route('reviews.create', $userId)->with('success', 'Review submitted successfully');
    }
}
