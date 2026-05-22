<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::where('user_id', auth()->id())->get();
        return view('pages.book.index', [
            'books' => $books,
            'title' => 'Buku',
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.book.create', [
            'title' => 'Tambah Buku',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|unique:books|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['status'] = $validated['stock'] > 0 ? 'Tersedia' : 'Tidak Tersedia';
        $validated['user_id'] = auth()->id();

        Book::create($validated);

        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'staff';
        return redirect()->route($prefix . '.books.index')->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.book.edit', [
            'book' => $book,
            'title' => 'Edit Buku',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'author' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn,' . $id . '|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['status'] = $validated['stock'] > 0 ? 'Tersedia' : 'Tidak Tersedia';

        $book->update($validated);

        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'staff';
        return redirect()->route($prefix . '.books.index')->with('success', 'Buku berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);

        if ($book->user_id !== auth()->id()) {
            abort(403);
        }

        $book->delete();

        $prefix = auth()->user()->role === 'admin' ? 'admin' : 'staff';
        return redirect()->route($prefix . '.books.index')->with('success', 'Buku berhasil dihapus');
    }
}
