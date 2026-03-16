<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;

class MemberController extends Controller
{
    public function dashboard()
    {
        $user   = Auth::user();
        $orders = $user->orders()->latest()->take(5)->get();
        return view('member.dashboard', compact('user', 'orders'));
    }

    public function orders()
    {
        $user   = Auth::user();
        $orders = $user->orders()->latest()->paginate(10);
        return view('member.orders', compact('orders'));
    }

    public function settings()
    {
        $user = Auth::user();
        return view('member.settings', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password berhasil diubah.');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user = Auth::user();

        // Delete old photo
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        $user->update(['profile_photo' => $path]);

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function printInvoice(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        $order->load(['items.product', 'user']);
        return view('member.invoice', compact('order'));
    }
}
