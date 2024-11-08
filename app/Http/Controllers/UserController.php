<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\KoleksiPribadi; // Import the KoleksiPribadi model
use App\Models\Buku; // Import the Buku model to get book details

class UserController extends Controller
{
    public function showProfile()
    {
        $userId = session('userid');

        if (!$userId) {
            return redirect('/login')->with('error', 'Please log in to view your profile.');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect('/login')->with('error', 'User not found.');
        }

        // Fetch the user's personal collection of books
        $koleksi = KoleksiPribadi::where('userid', $userId)->with('buku')->get();

        return view('profile', compact('user', 'koleksi'));
    }

    public function deleteFromCollection($koleksiid)
    {
        $koleksi = KoleksiPribadi::find($koleksiid);

        if ($koleksi && $koleksi->userid == session('userid')) {
            $koleksi->delete();
            return redirect()->back()->with('success', 'Book removed from your collection.');
        }

        return redirect()->back()->with('error', 'Failed to remove book.');
    }

    public function logout(Request $request)
    {
        // Clear the session
        $request->session()->flush();

        // Redirect to login with a message
        return redirect('/login')->with('success', 'You have been logged out.');
    }

    public function checkOverdue()
{
    $userId = Auth::id(); // Or use session('userid') if session is used

    $today = \Carbon\Carbon::now();

    // Fetch overdue books for this user and include book details
    $overdueBooks = Peminjaman::where('userid', $userId)
        ->where('tanggalpengembalian', '<', $today)
        ->where('statuspeminjaman', 'Dipinjam')
        ->with('buku') // Ensure the relationship is defined in the model
        ->get();

    $hasOverdue = $overdueBooks->isNotEmpty();

    return response()->json([
        'hasOverdue' => $hasOverdue,
        'overdueBooks' => $overdueBooks->map(function($peminjaman) {
            return [
                'bukuid' => $peminjaman->bukuid,
                'judul' => $peminjaman->buku->judul, // Fetch book title
                'tanggalpengembalian' => \Carbon\Carbon::parse($peminjaman->tanggalpengembalian)->format('Y-m-d'), // Parse and format date
            ];
        })
    ]);
}

}
