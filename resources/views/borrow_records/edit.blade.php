@extends('layouts.app')

@section('title', 'Edit Borrow Record')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Peminjaman</h2>
    <a href="{{ route('borrow-records.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('borrow-records.update', $borrowRecord->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="member_id" class="form-label">Anggota *</label>
                        <select class="form-control @error('member_id') is-invalid @endrext"
                            id="member_id" name="member_id" required>
                            <option value="">Pilih Anggota</option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id', $borrowRecord->member_id) == $member->id ? 'selected' : '' }}>
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
                            @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id', $borrowRecord->book_id) == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} - {{ $book->author->name }}
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
                        <input type="date" class="form-control @error('borrow_date') is-invalid @endrext"
                            id="borrow_date" name="borrow_date" value="{{ old('borrow_date', $borrowRecord->borrow_date) }}" required>
                        @error('borrow_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="due_date" class="form-label">Tanggal Jatuh Tempo *</label>
                        <input type="date" class="form-control @error('due_date') is-invalid @endrext"
                            id="due_date" name="due_date" value="{{ old('due_date', $borrowRecord->due_date) }}" required>
                        @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            @if($borrowRecord->return_date)
            <div class="mb-3">
                <label for="return_date" class="form-label">Tanggal Kembali</label>
                <input type="date" class="form-control"
                    id="return_date" name="return_date" value="{{ old('return_date', $borrowRecord->return_date) }}">
            </div>
            @endif

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection