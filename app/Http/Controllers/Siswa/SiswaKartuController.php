<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SiswaKartuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Generate Member ID: ID-{id}-PX-{year}
        $memberId = 'ID-' . $user->id . '-PX-' . $user->created_at->format('Y');

        return view('siswa.kartu-anggota', compact('user', 'memberId'));
    }
}
