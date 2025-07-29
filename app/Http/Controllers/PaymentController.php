<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CustomPackage;
use App\Models\Package;
use App\Models\Payment;
use DB;
use Illuminate\Http\Request;
use Log;
use Stripe\PaymentIntent;
use Stripe\Stripe;
use Yajra\DataTables\DataTables;

class PaymentController extends Controller
{
    // get data in datatable
    public function getPayments(Request $request)
    {
        try {
            if ($request->ajax() && $request->type == 'payment') {
                $query = Payment::with(['package', 'user']);

                if (!auth()->user()->hasRole('admin')) {
                    $query->where('user_id', auth()->id())->latest()->get();
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('user_id', fn($row) => optional($row->user)->id ?? 'N/A')
                    ->addColumn('booking_id', fn($row) => $row->booking_id ?? 'N/A')
                    ->addColumn('package_id', fn($row) => optional($row->package)->id ?? 'N/A')
                    ->addColumn('amount', fn($row) => $row->amount ?? 'N/A')

                    ->addColumn('payment_status', function ($row) {
                        return $row->payment_status == 'success'
                            ? '<span class="badge bg-success">success</span>'
                            : '<span class="badge bg-info">pending</span>';
                    })
                    ->addColumn(
                        'action',
                        fn($row) =>
                        '<a href="' . route('payments.show', $row->id) . '" class="btn btn-sm btn-primary">Show</a>'
                    )

                    ->rawColumns(['payment_status', 'action'])
                    ->make(true);
            }

            if ($request->ajax() && $request->type == 'booking') {
                $query = Booking::with(['package', 'user']);

                if (!auth()->user()->hasRole('admin')) {
                    $query->where('user_id', auth()->id())->latest()->get();
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('user_name', function ($row) {
                        return $row->user ? $row->user->username : 'N/A';
                    })
                    ->addColumn('package_id', fn($row) => optional($row->package)->id ?? 'N/A')
                    ->addColumn('name', fn($row) => $row->name ?? 'N/A')
                    ->addColumn('email', fn($row) => $row->email ?? 'N/A')
                    ->addColumn('booking_date', fn($row) => $row->booking_date ?? 'N/A')
                    ->rawColumns(['package_id', 'user_id'])
                    ->make(true);
            }

            return abort(403);
        } catch (\Exception $e) {
            logger('Error in payment datatable: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    // use for show detail
    public function show($id)
    {
        $payment = Payment::with('user', 'package', 'booking')->findOrFail($id);
        // dd($payment->booking);
        return view('admin.paymentshow', compact('payment'));
    }



    public function createPaymentIntent(Request $request)
    {

        try {
            $package = Package::findOrFail($request->package_id);

            Stripe::setApiKey(env('STRIPE_SECRET'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $package->price * 100,
                'currency' => 'usd',
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe PaymentIntent Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
    public function createCustomPaymentIntent(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:custom_packages,id',
        ]);

        $package = CustomPackage::findOrFail($request->package_id);

        Stripe::setApiKey(config('services.stripe.secret'));

        // Convert to integer cents:
        // If $package->price is stored as e.g. 1105.00 dollars, multiply by 100 and round.
        $amountInCents = (int) round($package->price * 100);

        $intent = PaymentIntent::create([
            'amount' => $amountInCents,
            'currency' => 'usd',
            'metadata' => [
                'custom_package_id' => $package->id,
                'user_id' => auth()->id(),
            ],
        ]);

        return response()->json([
            'clientSecret' => $intent->client_secret,
            'paymentIntentId' => $intent->id,
        ]);
    }

    public function datastore(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'package_id' => 'required|exists:packages,id',
                'booking_date' => 'required|date',
                'name' => 'required|string|max:255',
                'email' => 'required|email',
            ]);

            $userId = auth()->id();
            $package = Package::findOrFail($request->package_id);

            $booking = Booking::create([
                'user_id' => $userId,
                'package_id' => $request->package_id,
                'booking_date' => $request->booking_date,
                'name' => $request->name,
                'email' => $request->email,
            ]);

            Payment::create([
                'user_id' => $userId,
                'package_id' => $request->package_id,
                'booking_id' => $booking->id,
                'stripe_payment_id' => $request->payment_intent_id,
                'amount' => $package->price,
                'payment_status' => 'success',
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Booking & Payment saved successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Data Store Successfully' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}

