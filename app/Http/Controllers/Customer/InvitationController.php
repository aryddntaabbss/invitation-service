<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invitation;
use App\Models\Package;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customer = Auth::guard('customer')->user();
        $invitations = $customer->invitations()
            ->with(['package', 'template'])
            ->latest()
            ->paginate(10); // ← GUNAKAN PAGINATION

        return view('customer.invitations.index', compact('invitations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $packages = Package::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->get();

        return view('customer.invitations.create', compact('packages', 'templates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'template_id' => 'required|exists:templates,id',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_address' => 'required|string|max:1000',
            'google_maps_link' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'groom_bio' => 'nullable|string|max:500',
            'bride_bio' => 'nullable|string|max:500',
            'groom_parents' => 'nullable|string|max:255',
            'bride_parents' => 'nullable|string|max:255',
        ]);

        // Hitung expiry date berdasarkan package
        $package = Package::find($validated['package_id']);
        $expiresAt = now()->addDays($package->duration_days);

        // Create invitation
        $invitation = Invitation::create([
            'customer_id' => Auth::guard('customer')->id(),
            'package_id' => $validated['package_id'],
            'template_id' => $validated['template_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title'] . ' ' . Str::random(6)),
            'groom_name' => $validated['groom_name'],
            'bride_name' => $validated['bride_name'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'],
            'event_address' => $validated['event_address'],
            'google_maps_link' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'groom_bio' => $validated['groom_bio'] ?? null,
            'bride_bio' => $validated['bride_bio'] ?? null,
            'groom_parents' => $validated['groom_parents'] ?? null,
            'bride_parents' => $validated['bride_parents'] ?? null,
            'expires_at' => $expiresAt,
            'status' => 'draft',
        ]);

        return redirect()->route('customer.invitations.show', $invitation)
            ->with('success', 'Undangan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invitation $invitation)
    {
        // Authorization check - ensure customer owns this invitation
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $invitation->load(['package', 'template', 'guests', 'messages']);

        return view('customer.invitations.show', compact('invitation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invitation $invitation)
    {
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $packages = Package::where('is_active', true)->get();
        $templates = Template::where('is_active', true)->get();

        return view('customer.invitations.edit', compact('invitation', 'packages', 'templates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invitation $invitation)
    {
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'package_id' => 'required|exists:packages,id',
            'template_id' => 'required|exists:templates,id',
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'required',
            'event_address' => 'required|string|max:1000',
            'google_maps_link' => 'nullable|url|max:500',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'groom_bio' => 'nullable|string|max:500',
            'bride_bio' => 'nullable|string|max:500',
            'groom_parents' => 'nullable|string|max:255',
            'bride_parents' => 'nullable|string|max:255',
        ]);

        $invitation->update($validated);

        return redirect()->route('customer.invitations.show', $invitation)
            ->with('success', 'Undangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invitation $invitation)
    {
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $invitation->delete();

        return redirect()->route('customer.invitations.index')
            ->with('success', 'Undangan berhasil dihapus!');
    }

    /**
     * Publish the invitation
     */
    public function publish(Invitation $invitation)
    {
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $invitation->update([
            'status' => 'published',
            'published_at' => now(),
            'is_active' => true,
        ]);

        return back()->with('success', 'Undangan berhasil dipublikasikan!');
    }

    /**
     * Unpublish the invitation
     */
    public function unpublish(Invitation $invitation)
    {
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        $invitation->update([
            'status' => 'draft',
            'is_active' => false,
        ]);

        return back()->with('success', 'Undangan berhasil disembunyikan!');
    }

    /**
     * Show invitation preview
     */
    public function preview(Invitation $invitation)
    {
        // Authorization check - ensure customer owns this invitation
        if ($invitation->customer_id !== Auth::guard('customer')->id()) {
            abort(403, 'Unauthorized');
        }

        // Load necessary relationships
        $invitation->load(['template', 'package']);

        return view('customer.invitations.preview', compact('invitation'));
    }
}
