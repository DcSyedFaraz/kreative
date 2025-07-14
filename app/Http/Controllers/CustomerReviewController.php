<?php

namespace App\Http\Controllers;

use App\Models\CustomerReview;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class CustomerReviewController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $customers = User::whereHas('reviews', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        // dd($customers);

        return view('customer-reviews.index', compact('user', 'customers'));
    }

    public function create($customerId)
    {
        $customer = User::findOrFail($customerId);
        return view('customer-reviews.create', compact('customer'));
    }

    public function store(Request $request, $customerId)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = new CustomerReview([
            'provider_id' => Auth::id(),
            'customer_id' => $customerId,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        $review->save();

        return redirect()->route('customer-reviews.create', $customerId)
            ->with('success', 'Review submitted successfully');
    }

    public function show()
    {
        // dd('customer reviews');
        $user = Auth::user();
        $reviewsReceived = $user->customerReviewsReceived;

        return view('customer-reviews.show', compact('user', 'reviewsReceived'));
    }
}
