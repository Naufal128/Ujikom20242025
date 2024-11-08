<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman; // Import Peminjaman model
use Illuminate\Http\Request;
use App\Models\Ulasan;
use App\Models\KoleksiPribadi;
use Carbon\Carbon; // For date handling
use Auth; // Assuming user authentication is in place

class BookController extends Controller
{
    public function show($bukuid)
{
    $book = Buku::where('bukuid', $bukuid)->firstOrFail();

    // Check if user has borrowed the book and its current status
    $peminjaman = Peminjaman::where('bukuid', $bukuid)
                            ->where('userid', Auth::id())
                            ->where('statuspeminjaman', 'Dipinjam')
                            ->first();

    // Retrieve the ulasan (reviews) for this book
    $ulasan = Ulasan::where('bukuid', $bukuid)->with('user')->get();

    return view('book', compact('book', 'peminjaman', 'ulasan')); // Pass the ulasan to the view
}

public function borrow(Request $request, $bukuid)
{
    $userId = Auth::id();

    // Validate the request, including the return date
    $request->validate([
        'tanggalpengembalian' => 'required|date|after:today',
        'jumlah' => 'required|integer|min:1',
    ]);

    // Check if user has already borrowed 3 books
    $borrowedCount = Peminjaman::where('userid', $userId)
                               ->where('statuspeminjaman', 'Dipinjam')
                               ->count();

    if ($borrowedCount >= 3) {
        return back()->withErrors('You cannot borrow more than 3 books at a time.');
    }

    // Check if the requested quantity is available
    $book = Buku::findOrFail($bukuid);
    if ($book->stok < $request->jumlah) {
        return back()->withErrors('Stok tidak mencukupi untuk jumlah peminjaman yang diminta.');
    }

    // Create a new borrowing record
    Peminjaman::create([
        'userid' => $userId,
        'bukuid' => $bukuid,
        'tanggalpeminjaman' => Carbon::now(),
        'tanggalpengembalian' => $request->tanggalpengembalian, // User-selected return date
        'jumlah' => $request->jumlah,
        'statuspeminjaman' => 'Dipinjam',
    ]);

    // Decrease the stock by the borrowed quantity
    $book->stok -= $request->jumlah;
    $book->save();

    return back()->with('success', 'Buku berhasil dipinjam!');
}

 
public function return(Request $request, $bukuid)
{
    $userId = Auth::id();

    // Find the borrowing record and update it to mark as returned
    $peminjaman = Peminjaman::where('bukuid', $bukuid)
                            ->where('userid', $userId)
                            ->where('statuspeminjaman', 'Dipinjam')
                            ->firstOrFail();

    // Update the borrowing record to mark it as returned
    $peminjaman->update([
        'statuspeminjaman' => 'Kembali',
        'tanggalpengembalian' => Carbon::now(),
    ]);

    // Increase the stock of the book by the number of copies borrowed
    $book = Buku::findOrFail($bukuid);
    $book->stok += $peminjaman->jumlah; // Increase stock by the quantity borrowed
    $book->save();

    return back()->with('success', 'Buku berhasil dikembalikan!');
} 

public function storeUlasan(Request $request, $bukuid)
{
    // Validate input
    $request->validate([
        'ulasan' => 'required|string|max:1000',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    // Check if the user has borrowed or returned the book
    $userId = Auth::id();

    // This checks if there is any borrowing or returning activity (Dipinjam or Kembali) for this book by the user
    $peminjaman = Peminjaman::where('bukuid', $bukuid)
                            ->where('userid', $userId)
                            ->whereIn('statuspeminjaman', ['Dipinjam', 'Kembali'])  // Changed to whereIn
                            ->exists();

    // If no such record exists, return an error
    if (!$peminjaman) {
        return back()->withErrors('Anda harus meminjam atau mengembalikan buku ini untuk memberikan ulasan.');
    }

    // Create the review
    Ulasan::create([
        'userid' => $userId,
        'bukuid' => $bukuid,
        'ulasan' => $request->ulasan,
        'rating' => $request->rating,
    ]);

    return back()->with('success', 'Ulasan berhasil dikirim!');
}
    
    public function updateUlasan(Request $request, $bukuid, $ulasanid)
{
    $request->validate([
        'ulasan' => 'required',
        'rating' => 'required|integer|min:1|max:5',
    ]);

    $ulasan = Ulasan::where('ulasanid', $ulasanid)->where('userid', auth()->user()->userid)->firstOrFail();
    $ulasan->update([
        'ulasan' => $request->ulasan,
        'rating' => $request->rating,
    ]);

    return redirect()->route('book.show', $bukuid)->with('success', 'Ulasan berhasil diperbarui.');
}

public function deleteUlasan($bukuid, $ulasanid)
{
    $ulasan = Ulasan::where('ulasanid', $ulasanid)->where('userid', auth()->user()->userid)->firstOrFail();
    $ulasan->delete();

    return redirect()->route('book.show', $bukuid)->with('success', 'Ulasan berhasil dihapus.');
}

public function addToKoleksi($bukuid)
    {
        $userId = Auth::id();

        // Check if the book is already in the user's collection
        $existingKoleksi = KoleksiPribadi::where('userid', $userId)
                                         ->where('bukuid', $bukuid)
                                         ->first();

        if ($existingKoleksi) {
            return back()->with('error', 'Buku ini sudah ada dalam koleksi Anda.');
        }

        // Add the book to the user's collection
        KoleksiPribadi::create([
            'userid' => $userId,
            'bukuid' => $bukuid,
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke koleksi pribadi.');
    }
 
}
