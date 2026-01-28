@extends('layouts.app')

@section('title', 'Peminjaman')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Peminjaman</h2>
    <a href="{{ route('borrow-records.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Pinjam Buku
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('borrow-records.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <select class="form-control" name="status">
                    <option value="">Semua Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Terlambat</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowRecords as $record)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $record->member->name }}</td>
                    <td>{{ $record->book->title }}</td>
                    <td>{{ $record->borrow_date }}</td>
                    <td>{{ $record->due_date }}</td>
                    <td>
                        @if($record->status == 'borrowed')
                        <span class="badge bg-warning">Dipinjam</span>
                        @elseif($record->status == 'returned')
                        <span class="badge bg-success">Dikembalikan</span>
                        @else
                        <span class="badge bg-danger">Terlambat</span>
                        @endif
                    </td>
                    <td>
                        @if($record->status == 'borrowed')
                        <form action="{{ route('borrow-records.return', $record->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Kembalikan buku ini?')">
                                <i class="fas fa-check"></i> Kembalikan
                            </button>
                        </form>
                        @endif
                        <form action="{{ route('borrow-records.destroy', $record->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data peminjaman</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection