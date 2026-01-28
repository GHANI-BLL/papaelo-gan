@extends('layouts.app')

@section('title', 'Pinjam Buku')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Pinjam Buku Baru</h2>
    <a href="{{ route('borrow-records.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('borrow-records.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="member_id" class="form-label">Anggota *</label>
                        <select class="form-control @error('member_id') is-invalid @enderror"
                            id="member_id" name="member_id" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->email }})
                            </option>
                            @endforeach
                        </select>
                        @error('member_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="book_id" class="form-label">Buku *</label>
                        <select class="form-control @error('book_id') is-invalid @endrext"
                            id="book_id" name="book_id" required>
                            <option value="">Pilih Buku</option>
                            @foreach($availableBooks as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author->name }} (Tersedia: {{ $book->available_copies }})
                            </option>
                            @endforeach
                        </select>
                        @error('book_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="borrow_date" class="form-label">Tanggal Pinjam *</label>
                        <input type="date" class="form-control @error('borrow_date') is-invalid @enderror"
                            id="borrow_date" name="borrow_date" value="{{ old('borrow_date', date('Y-m-d')) }}" required>
                        @error('borrow_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Tanggal Jatuh Tempo *</label>
                        <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                            id="due_date" name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-book-reader"></i> Proses Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>
@endsection