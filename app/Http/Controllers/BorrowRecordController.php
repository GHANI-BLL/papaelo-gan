<?php

namespace App\Http\Controllers;

use App\Models\BorrowRecord;
use App\Models\Member;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BorrowRecord::with(['member', 'book']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $borrowRecords = $query->orderBy('created_at', 'desc')->get();
        return view('borrow_records.index', compact('borrowRecords'));
    }

    /**
     * Show the form for creating a new resource (borrow book).
     */
    public function create()
    {
        $members = Member::where('status', 'active')->get();
        $availableBooks = Book::where('available_copies', '>', 0)->get();
        return view('borrow_records.create', compact('members', 'availableBooks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'book_id' => 'required',
            'borrow_date' => 'required',
            'due_date' => 'required',
        ]);

        // Check book availability
        $book = Book::findOrFail($request->book_id);
        if ($book->available_copies < 1) {
            return redirect()->back()->with('error', 'Book is not available.');
        }

        DB::transaction(function () use ($request, $book) {
            // Create borrow record
            BorrowRecord::create([
                'member_id' => $request->member_id,
                'book_id' => $request->book_id,
                'borrow_date' => $request->borrow_date,
                'due_date' => $request->due_date,
                'status' => 'borrowed',
            ]);

            // Update available copies
            $book->decrement('available_copies');
        });

        return redirect()->route('borrow_records.index')
            ->with('success', 'Book borrowed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BorrowRecord $borrowRecord)
    {
        return view('borrow_records.show', compact('borrowRecord'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BorrowRecord $borrowRecord)
    {
        $members = Member::where('status', 'active')->get();
        $books = Book::all();
        return view('borrow_records.edit', compact('borrowRecord', 'members', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BorrowRecord $borrowRecord)
    {
        $request->validate([
            'member_id' => 'required',
            'book_id' => 'required',
            'borrow_date' => 'required',
            'due_date' => 'required',
        ]);

        $borrowRecord->update($request->all());

        return redirect()->route('borrow_records.index')
            ->with('success', 'Borrow record updated successfully.');
    }

    /**
     * Return a book.
     */
    public function returnBook(BorrowRecord $borrowRecord)
    {
        if ($borrowRecord->status !== 'returned') {
            DB::transaction(function () use ($borrowRecord) {
                $borrowRecord->update([
                    'return_date' => now()->toDateString(),
                    'status' => 'returned',
                ]);

                $borrowRecord->book->increment('available_copies');
            });

            return redirect()->route('borrow_records.index')
                ->with('success', 'Book returned successfully.');
        }

        return redirect()->route('borrow_records.index')
            ->with('error', 'Book already returned.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BorrowRecord $borrowRecord)
    {
        // If book was borrowed, restore availability
        if ($borrowRecord->status === 'borrowed') {
            $borrowRecord->book->increment('available_copies');
        }

        $borrowRecord->delete();

        return redirect()->route('borrow_records.index')
            ->with('success', 'Borrow record deleted successfully.');
    }
}
