@extends('layouts.app')

@section('title', 'Create Author')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Tambah Penulis Baru</h2>
    <a href="{{ route('authors.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('authors.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Penulis *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                    id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="birth_year" class="form-label">Tahun Lahir</label>
                <input type="number" class="form-control @error('birth_year') is-invalid @enderror"
                    id="birth_year" name="birth_year" value="{{ old('birth_year') }}">
                @error('birth_year')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="biography" class="form-label">Biografi</label>
                <textarea class="form-control @error('biography') is-invalid @enderror"
                    id="biography" name="biography" rows="4">{{ old('biography') }}</textarea>
                @error('biography')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection