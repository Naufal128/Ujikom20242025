<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Buku;
use App\Models\KategoriBukuRelasi;
use Illuminate\Support\Facades\Auth; // Import Auth for authentication
use Illuminate\Http\Request;
use App\Models\User;

class PrimaryController extends Controller
{
    public function index()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the authenticated user's data
            $user = Auth::user(); // Retrieve the authenticated user

            // Store the userid in the session
            session(['userid' => $user->userid]);

            // Fetch categories and books along with relationships
            $categories = Kategori::all();
            $books = Buku::with('kategoris')->get();
            $relations = KategoriBukuRelasi::with('buku', 'kategori')->get();

            // Pass the authenticated user's data to the view along with categories and books
            return view('home', [
                'user' => $user, 
                'categories' => $categories, 
                'books' => $books, 
                'relations' => $relations
            ]);
        } else {
            // If user is not authenticated, redirect to login
            return redirect()->route('login')->with('error', 'You must be logged in to access the Beranda.');
        }
    }
}