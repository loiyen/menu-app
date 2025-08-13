<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\pembayarans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::user();
        $pembayaran = pembayarans::sum('jumlah_bayar');

        return view('backsite.akun.halamanAkun', [
            'user' => $request->user(),
            'title' => 'Akun || Coffe',
            'user' => $user,
            'pembayaran' => $pembayaran,
        ]);
        
        // return view('profile.edit', [
        //     'user' => $request->user(),
        //     'title' => 'Akun || Coffe',
        //     'user' => $user,
        //     'pembayaran' => $pembayaran,
        // ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
