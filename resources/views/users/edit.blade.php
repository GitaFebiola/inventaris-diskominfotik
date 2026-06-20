@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

<div class="card shadow-sm">
    <div class="card-header">
        <h5 class="mb-0">Edit Profile: {{ $user->name }}</h5>
    </div>

    <div class="card-body">
        
        {{-- ALERT ERROR (Password Salah) --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ALERT INFO (Tidak Ada Perubahan) --}}
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- ALERT VALIDASI --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-9">
                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                </div>
            </div>

            <hr>
            <p class="text-muted small"><strong>Ganti Password:</strong> Isi kolom di bawah ini jika ingin mengubah password.</p>
            
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password Lama <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <input type="password" name="old_password" class="form-control" placeholder="Masukkan password lama Anda" value="{{ old('old_password') }}">
                    @error('old_password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Password Baru</label>
                <div class="col-sm-9">
                    <input type="password" name="password" class="form-control" placeholder="Password baru (Minimal 5 karakter)">
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                <div class="col-sm-9">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru">
                    @error('password_confirmation')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-9 offset-sm-3">
                    <a href="{{ route('profile') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection