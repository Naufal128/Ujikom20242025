<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        return view('login');
    } 

    public function login(Request $request)
{
    // Validate the login form data
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Attempt to log the user in using their credentials
    if (Auth::attempt($credentials)) {
        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Get the authenticated user
        $user = Auth::user(); // Retrieve the authenticated user

        // Store user name and email in session
        $request->session()->put('user_name', $user->username);
        $request->session()->put('email', $user->email);

        // Check for overdue peminjaman
        $overduePeminjaman = \App\Models\Peminjaman::where('userid', $user->userid)
            ->where('statuspeminjaman', 'Dipinjam')  // Book is still borrowed
            ->where('tanggalpengembalian', '<', now()) // Due date has passed
            ->get();

        // If there are overdue books, store the data in the session
        if ($overduePeminjaman->isNotEmpty()) {
            $request->session()->put('overdue_books', $overduePeminjaman);
        }

        // Redirect to /beranda upon successful login
        return redirect()->intended('/beranda');
    }

    // If login fails, redirect back with an error message
    return back()->withErrors([
        'login' => 'The provided credentials do not match our records.',
    ]);
}

    // Show registration form
    public function showRegisterForm()
    {
        return view('register');
    }

    // Handle registration request
    public function register(Request $request)
{
    // Validate the input fields
    $validatedData = $request->validate([
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'namalengkap' => 'required|string|max:255',
        'alamat' => 'required|string',
        'telepon' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Try to insert data and catch any exceptions
    try {
        // Create the user
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'namalengkap' => $validatedData['namalengkap'],
            'alamat' => $validatedData['alamat'],
            'telepon' => $validatedData['telepon'],
            'password' => Hash::make($validatedData['password']), // Encrypt the password
        ]);

        // Automatically log in the user after registration
        Auth::login($user);

        // Redirect to dashboard
        return redirect('/login')->with('success', 'Registration successful');
    } catch (\Exception $e) {
        // Log error and show message
        \Log::error($e->getMessage());
        return redirect()->back()->withErrors(['msg' => 'Registration failed.']);
    }
  }
}