<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CustomPackage;
use App\Models\Payment;
use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        try {
            if ($request->ajax()) {
                if ($request->type === 'custom-package') {
                    $query = CustomPackage::with(['provider', 'user']);

                    // non-admins only see their own
                    if (auth()->user()->hasRole('service provider')) {
                        $query->where('service_provider_id', auth()->id());
                    } else if (auth()->user()->hasRole('user')) {
                        $query->where('user_id', auth()->id());
                    }

                    return DataTables::of($query)
                        ->addIndexColumn()
                        ->addColumn('service_provider', fn($row) => optional($row->provider)->fname ?? 'N/A')
                        ->addColumn('user', fn($row) => optional($row->user)->fname ?? 'N/A')
                        ->addColumn('name', fn($row) => $row->name)
                        ->addColumn('price', fn($row) => number_format($row->price, 2))
                        ->addColumn('payment_status', function ($row) {
                            return $row->payment_status === 'completed'
                                ? '<span class="badge bg-success">Completed</span>'
                                : '<span class="badge bg-info">Pending</span>';
                        })
                        ->addColumn(
                            'action',
                            fn($row) =>
                            '<a href="' . route('custom-packages.show', $row->id) . '" class="btn btn-sm btn-primary">Show</a>'
                        )
                        ->rawColumns(['payment_status', 'action'])
                        ->make(true);
                }
                if ($request->type == 'payment') {
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

                if ($request->type == 'booking') {
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
            }

            // Get unread message count for sidebar notification
            $user = auth()->user();
            $unreadCount = 0;

            if ($user) {
                $unreadCount = ChatRoom::where(function ($query) use ($user) {
                    $query->where('client_id', $user->id)
                          ->orWhere('service_provider_id', $user->id);
                })
                ->whereColumn('client_id', '!=', 'service_provider_id')
                ->withCount(['messages' => function($query) use ($user) {
                    $query->where('user_id', '!=', $user->id)
                          ->where('created_at', '>', now()->subDays(7));
                }])
                ->get()
                ->sum('messages_count');
            }

            return view('admin.dashboard', compact('unreadCount'));
        } catch (\Exception $e) {
            logger('Error in payment datatable: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function teacher()
    {
        return view('admin.teacher_dashboard');
    }

    public function student()
    {
        return view('admin.student_dashboard');
    }
}
