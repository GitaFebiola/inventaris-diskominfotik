@extends('layouts.admin')

@section('title', 'Manajemen User')

@section('content')

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Daftar Pengguna</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle datatable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Terdaftar Sejak</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $item)
                    <tr>
                        {{-- Gunakan $loop->iteration untuk Nomor Otomatis --}}
                        <td class="text-center">{{ $loop->iteration }}</td>
                        
                        <td>
                            {{ $item->name }}
                        </td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                        <td class="text-center">
                            {{-- LOGIKA ADMIN UTAMA --}}
                            @if($item->id === 1)
                                <span class="badge bg-primary ms-2">Admin Utama</span>
                            @endif
                            
                            {{-- TOMBOL HAPUS: Hanya tampil jika BUKAN Admin Utama (ID 1) --}}
                            @if($item->id !== 1)
                            <form action="{{ route('users.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus user ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection