<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    public function showPeminjaman()
{
    $userid = Auth::id(); // Assuming you're using Laravel's Auth for user login

    // Fetch books the user is currently borrowing (status is 'Dipinjam')
    $currentLoans = Peminjaman::where('userid', $userid)
        ->where('statuspeminjaman', 'Dipinjam')
        ->with('buku') // Assuming you have a relation to the Buku model
        ->get();

    // Fetch the user's loan history (status is 'Kembali')
    $loanHistory = Peminjaman::where('userid', $userid)
        ->where('statuspeminjaman', 'Kembali')
        ->with('buku')
        ->get();

    return view('borrow', compact('currentLoans', 'loanHistory'));
}
}
