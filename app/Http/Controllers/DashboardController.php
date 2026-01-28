<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\BorrowRecord;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalBuku' => Book::count(),
            'totalAnggota' => Member::count(),
            'sedangDipinjam' => BorrowRecord::where('status', 'borrowed')->count(),
            'dikembalikan' => BorrowRecord::where('status', 'returned')->count(),
            'peminjamanTerbaru' => BorrowRecord::with(['member', 'book'])
                ->latest()
                ->take(5)
                ->get(),
            'bukuPopuler' => Book::withCount('borrowRecords')
                ->orderByDesc('borrow_records_count')
                ->take(5)
                ->get()
        ];

        return view('dashboard', $data);
    }
}
