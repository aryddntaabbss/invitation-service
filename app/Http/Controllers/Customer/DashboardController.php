<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Show the customer dashboard.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();

        // Get invitations with related data
        $invitations = Invitation::with(['package', 'template'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        // Calculate statistics
        $stats = [
            'total_invitations' => $invitations->count(),
            'active_invitations' => $invitations->where('is_active', true)->count(),
            'total_views' => $invitations->sum('view_count'),
        ];

        return view('customer.dashboard', compact('customer', 'invitations', 'stats'));
    }
}
