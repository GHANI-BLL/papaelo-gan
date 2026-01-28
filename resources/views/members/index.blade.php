@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Daftar Anggota</h2>
    <a href="{{ route('members.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Anggota
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('members.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <input type="text" class="form-control" name="search"
                    placeholder="Cari nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select class="form-control" name="status">
                    <option value="">Semua Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i> Filter
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Tanggal Gabung</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->phone ?? '-' }}</td>
                    <td>{{ $member->join_date }}</td>
                    <td>
                        <span class="badge bg-{{ $member->status == 'active' ? 'success' : 'secondary' }}">
                            {{ $member->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('members.edit', $member->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline">
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
                    <td colspan="7" class="text-center">Tidak ada data anggota</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection