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

        // Get invitations with related data - GUNAKAN PAGINATION
        $invitations = Invitation::with(['package', 'template'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10); // ← INI YANG DIPERBAIKI

        // Calculate statistics
        $stats = [
            'total_invitations' => $customer->invitations()->count(),
            'active_invitations' => $customer->invitations()->where('is_active', true)->count(),
            'total_views' => $customer->invitations()->sum('view_count'),
        ];

        return view('customer.dashboard', compact('customer', 'invitations', 'stats'));
    }
}
